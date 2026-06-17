FROM php:8.5-fpm-alpine

RUN apk update && apk upgrade && apk add --no-cache \
    nginx \
    icu-dev \
    icu-data-full \
 && docker-php-ext-install mysqli pdo pdo_mysql intl \
 && apk del tar curl libcurl \
 && rm -f /usr/bin/wget \
 && mkdir -p /run/nginx

COPY nginx-default.conf /etc/nginx/http.d/default.conf

COPY mrbs-code/web/ /var/www/html/
COPY mrbs-code/docker_app/php/config.inc.php /var/www/html/config.inc.php

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]