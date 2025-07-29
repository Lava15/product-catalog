FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \    
    autoconf build-base linux-headers \
    libzip-dev libmemcached-dev libmcrypt-dev \
    libzip-dev libxml2-dev \
    libxslt-dev zlib-dev oniguruma-dev icu-dev gmp-dev postgresql-dev \
    curl git unzip \
 && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath intl

RUN rm -rf /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apk add --no-cache shadow

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
 && chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
USER www-data
CMD ["php-fpm", "-F"]
