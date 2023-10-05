## Развертывание

1. Копируем репозиторий командой `git clone https://github.com/Izarych/testapiphp.git`
2. Переходим в директорию проекта `cd testapiphp`
3. Копируем файл `.env.example в .env` командой `copy`
4. В `.env` файле устанавливаем переменные для базы данных (как пример):
```yaml
DB_DATABASE=db
DB_USERNAME=postgres
DB_PASSWORD=password
```
5. В `docker-compose.yml` файле устанавливаем в сервисе postgresql переменные из п.4
6. Устанавливаем и запускаем образ командой `docker compose up --build -d`
7. Выполняем команды
```shell
docker-compose exec php-fpm composer install
docker-compose exec php-fpm php artisan:key generate
docker-compose exec php-fpm php artisan migrate
```
8.  Сайт доступен по url - `http://localhost`
9. API - группы маршрутов:
```yaml
http://localhost/api/bank
http://localhost/api/dealer
```
