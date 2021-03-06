FROM php:8.0.7-fpm-alpine3.13
RUN docker-php-ext-install pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
COPY config/env/dev.env .env
RUN composer install
