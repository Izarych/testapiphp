FROM php:8.1-fpm-buster

RUN apt-get update && apt-get install -y libpq-dev postgresql-client

RUN docker-php-ext-install pdo pdo_pgsql
RUN apt-get update && apt-get install -y zip unzip
RUN apt-get update && apt-get install -y git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# node.js и npm
# RUN apt-get update && apt-get install -y nodejs npm

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . .

RUN composer dump-autoload --optimize

CMD ["php-fpm"]
