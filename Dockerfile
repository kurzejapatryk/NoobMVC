# syntax=docker/dockerfile:1

# Use the official PHP image as the base image.

FROM php:8.2-apache as final

ENV DOCKER=true

RUN apt-get update -yqq
RUN apt-get install -yqq git libpq-dev libcurl4-gnutls-dev libicu-dev libvpx-dev libjpeg-dev libpng-dev libxpm-dev zlib1g-dev libfreetype6-dev libxml2-dev libexpat1-dev libbz2-dev libgmp3-dev libldap2-dev unixodbc-dev libsqlite3-dev libaspell-dev libsnmp-dev libpcre3-dev libtidy-dev libonig-dev libzip-dev libsodium-dev
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install mbstring pdo_pgsql pdo_mysql curl intl gd xml zip bz2 intl opcache sodium exif >> /dev/null
RUN docker-php-ext-enable pdo_mysql pdo_pgsql curl intl gd xml zip bz2 intl opcache sodium exif >> /dev/null
RUN a2enmod rewrite

COPY . /var/www/html

RUN mkdir -p /var/www/html/tmp
RUN mkdir -p /var/www/html/Uploads
RUN chmod -R 777 /var/www/html/tmp
RUN chmod -R 777 /var/www/html/Uploads

RUN curl -sS https://getcomposer.org/installer | php >> /dev/null
RUN php composer.phar install --prefer-dist --no-ansi --no-interaction --no-progress

# Switch to a non-privileged user (defined in the base image) that the app will run under.
# See https://docs.docker.com/go/dockerfile-user-best-practices/
USER www-data

