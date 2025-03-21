Dự án này tôi sử dụng Laravel Octane và có chức năng auth đơn giản sử dụng Sanctum thôi nhé.

```shell
#Build image show chi tiết log
docker-compose build --progress=plain

# Copy vendor trong container về máy host
docker cp laravel_octane_app:/var/www/vendor/. ./vendor

# Copy composer.lock trong container về máy host
docker cp laravel_octane_app:/var/www/composer.lock ./composer.lock

```
```shell
php artisan octane:start --server=swoole --watch --host=0.0.0.0 --port=8000
```

Khi clone project của tôi về các ông làm đúng các bước như sau:
Đứng tại máy host
```shell
$ docker-compose down --volumes  && docker-compose up --force-recreate --build

$ docker exec -it laravel_octane_app php artisan migrate

$ docker exec -it laravel_octane_app npm run dev -- --host 0.0.0.0 --port 5173
```
