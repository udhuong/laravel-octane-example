```shell
#Build image show chi tiết log
docker-compose build --progress=plain

# Copy vendor trong container về máy host
docker cp laravel_octane_app:/var/www/vendor/. ./vendor

```
```shell
php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
```

Khi clone project của tôi về các ông làm đúng các bước như sau:
```shell
$ docker-compose down --volumes  && docker-compose up --force-recreate --build

$ docker exec -it laravel_octane_app php artisan migrate
```
