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

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql gd opcache sockets pcntl posix

# Cài đặt Swoole
RUN pecl install swoole && docker-php-ext-enable swoole

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy mã nguồn
WORKDIR /var/www
COPY . .

# Sao chép file cấu hình php.ini
COPY ./docker/php.ini /usr/local/etc/php/conf.d/php.ini
# Sao chép file cấu hình OPcache
COPY ./docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
# Thêm file cấu hình Supervisor (nếu muốn quản lý Octane bằng Supervisor)
COPY ./docker/supervisor.conf /etc/supervisor.conf

# Phân quyền
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

USER www-data

RUN composer install --optimize-autoloader --no-dev

# Mở cổng cho Octane
EXPOSE 8000

# Lệnh khởi chạy Octane với Supervisor
CMD ["supervisord", "-c", "/etc/supervisor.conf"]
