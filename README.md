# Сервис коротких ссылок
### :whale: Запуск приложения в среде [Docker](https://docs.docker.com/engine/install/):
```shell
git https://github.com/primetz/short-links.git && \
cd short-links && \
docker compose -f ./docker/docker-compose.yaml up -d --build && \
docker exec -ti sl-php-fpm php bin/console doctrine:migrations:migrate -n
```
