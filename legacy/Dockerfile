FROM php:7.4-fpm

WORKDIR /var/www/

RUN apt-get update \
    && apt-get install -y libzip-dev \
    && apt-get install -y libpng-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000