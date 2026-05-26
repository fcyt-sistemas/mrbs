FROM php:8.4-apache

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
    libicu-dev \
    locales-all \
 && docker-php-ext-install mysqli pdo pdo_mysql intl \
 && a2enmod rewrite \
 && apt-get purge -y libicu-dev binutils \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY web/ /var/www/html/
COPY docker_app/php/config.inc.php /var/www/html/config.inc.php