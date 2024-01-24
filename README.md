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

#### $\color{#3caab5}{\mathsf{GET}}$ [http://localhost/api/links/{token}](http://localhost/api/links/{token}) - Получить ссылку по токену
#### <span style="color: #3caab5;">GET [http://localhost/api/links](http://localhost/api/links)</span> - Получить все ссылки
Необязательное поле с фильтрами
```js
{
    "deleted": true, // Необязательное поле типа bool
    "views": 34      // Необязательное поле типа int в выборку попадут все ссылки у которых больше 34 просмотров
}
```
#### <span style="color: #78bc61;">POST [http://localhost/api/links](http://localhost/api/links)</span> - Создать ссылку
```js
{
    "url": "https://www.php.net/manual/en/function.parse-url.php", // Обязательное поле - валидный url
     "deletedAt": "2025-02-04"                                     // Необязательное поле в формате "Y-m-d"
}
```
#### <span style="color: #50e3c2;">PATCH [http://localhost/api/links/{token}](http://localhost/api/links/{token})</span> - Обновить ссылку
```js
{
    "url": "https://www.php.net/manual/ru/filter.filters.validate.php", // Необязательное поле - валидный url
    "deletedAt": "11 hours"                                              // Необязательное поле в формате "int years|months|days|hours"
}
```
#### <span style="color: #ed6a5a;">DELETE [http://localhost/api/links/{token}](http://localhost/api/links/{token})</span> - Удалить ссылку - soft delete
