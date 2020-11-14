FROM php:7.4-apache

RUN apt-get update \
    && apt-get install -y libzip-dev

RUN docker-php-ext-install zip

RUN docker-php-ext-install mysqli

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite
