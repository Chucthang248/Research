FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    zlib1g-dev \
    libsasl2-dev \
    libssl-dev \
    pkg-config \
    && pecl install memcached \
    && docker-php-ext-enable memcached

WORKDIR /app
COPY . /app

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app"]
