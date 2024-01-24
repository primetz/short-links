# Сервис коротких ссылок
### :whale: Запуск приложения в среде [Docker](https://docs.docker.com/engine/install/):
```shell
git clone -b thin-with-uuid https://github.com/primetz/short-links.git && \
docker compose -f ./short-links/docker/docker-compose.yaml up -d --build && \
docker exec -ti sl-php-fpm composer install && \
sleep 10 && \
docker exec -ti sl-php-fpm php bin/console doctrine:migrations:migrate -n
```

### :spider: Методы API

#### $\color{#3caab5}{\textsf{GET}}$ [http://localhost/api/links/{token}](http://localhost/api/links/{token}) - Получить ссылку по токену
#### $\color{#3caab5}{\textsf{GET}}$ [http://localhost/api/links](http://localhost/api/links) - Получить все ссылки
Необязательное поле с фильтрами
```js
{
    "deleted": true, // Необязательное поле типа bool
    "views": 34      // Необязательное поле типа int в выборку попадут все ссылки у которых больше 34 просмотров
}
```
#### $\color{#78bc61}{\textsf{POST}}$ [http://localhost/api/links](http://localhost/api/links) - Создать ссылку
```js
{
    "url": "https://www.php.net/manual/en/function.parse-url.php", // Обязательное поле - валидный url
     "deletedAt": "2025-02-04"                                     // Необязательное поле в формате "Y-m-d"
}
```
#### $\color{#50e3c2}{\textsf{PATCH}}$ [http://localhost/api/links/{token}](http://localhost/api/links/{token}) - Обновить ссылку
```js
{
    "url": "https://www.php.net/manual/ru/filter.filters.validate.php", // Необязательное поле - валидный url
    "deletedAt": "11 hours"                                              // Необязательное поле в формате "int years|months|days|hours"
}
```
#### $\color{#ed6a5a}{\textsf{DELETE}}$ [http://localhost/api/links/{token}](http://localhost/api/links/{token}) - Удалить ссылку - soft delete
