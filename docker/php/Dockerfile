FROM composer:latest as composer
FROM php:7.4-fpm

ARG USER_ID
ARG GROUP_ID

RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0777 -o www-data -g www-data /home/www-data

RUN chown www-data:www-data /var/www

RUN apt-get update && apt-get install -y \
    wget \
    git \
    unzip \
    curl \
    vim \
    libpq-dev \
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_pgsql

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

COPY --from=composer /usr/bin/composer /usr/bin/composer

USER www-data

WORKDIR /var/www
