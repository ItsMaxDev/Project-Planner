FROM php:fpm

WORKDIR /app

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update -y && apt-get install -y unzip zlib1g-dev libpng-dev libfreetype6-dev

RUN docker-php-ext-configure gd --enable-gd --with-freetype

RUN docker-php-ext-install gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer