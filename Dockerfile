FROM php:8.3-alpine

# Cài đặt các gói cần thiết
RUN apk add --no-cache \
    supervisor \
    shadow \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    zip \
    unzip \
    bash \
    nano \
    linux-headers \
    autoconf \
    g++ \
    make

RUN apk add --no-cache curl && \
    curl -fsSL https://unofficial-builds.nodejs.org/download/release/v23.9.0/node-v23.9.0-linux-x64-musl.tar.gz | tar -xz -C /usr/local --strip-components=1 && \
    npm install -g npm \
    && npm install chokidar

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql gd opcache sockets pcntl posix

# Cài đặt Swoole
RUN pecl install swoole && docker-php-ext-enable swoole

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tạo thư mục làm việc
WORKDIR /var/www

# Sao chép composer.json và composer.lock trước
COPY composer.json ./
RUN if [ -f "composer.lock" ]; then cp composer.lock ./; fi

# Cài đặt dependencies trước khi thêm source code
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy toàn bộ source code vào container
COPY --chown=www-data:www-data . .

# Chạy lại composer để kích hoạt các scripts của Laravel
RUN composer dump-autoload && composer run-script post-autoload-dump

# Sao chép file cấu hình php.ini
COPY ./docker/php.ini /usr/local/etc/php/conf.d/php.ini
# Sao chép file cấu hình OPcache
COPY ./docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
# Thêm file cấu hình Supervisor (nếu muốn quản lý Octane bằng Supervisor)
COPY ./docker/supervisor.conf /etc/supervisor.conf

# Phân quyền thư mục storage và bootstrap/cache
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Chạy container với quyền www-data
USER www-data

# Mở cổng cho Octane
EXPOSE 8000

# Lệnh khởi chạy Octane với Supervisor
CMD ["supervisord", "-c", "/etc/supervisor.conf"]
