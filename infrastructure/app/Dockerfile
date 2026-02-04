FROM composer:2 AS composer

FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev \
    git \
    unzip \
    bash

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg && \
    docker-php-ext-install \
    pdo_pgsql \
    mbstring \
    intl \
    bcmath \
    exif \
    pcntl \
    gd \
    zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php-fpm"]
