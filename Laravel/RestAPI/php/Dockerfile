FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cài Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Sao chép file cấu hình PHP
COPY php.ini /usr/local/etc/php/

WORKDIR /var/www/html
