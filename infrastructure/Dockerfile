FROM php:8.3-cli

RUN apt-get update

RUN apt-get install -y libbz2-dev libgmp-dev libzip-dev \
    && docker-php-ext-install -j$(nproc) bz2 gmp zip \
    && docker-php-ext-enable bz2 gmp sodium zip

RUN pecl install redis-6.0.2 \
    && pecl install xdebug-3.3.2 \
    && docker-php-ext-enable redis xdebug

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN curl -s -o symfony-cli-installer https://get.symfony.com/cli/installer \
    && bash symfony-cli-installer --install-dir /usr/bin \
    && rm symfony-cli-installer

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY infrastructure/zz-docker.ini "$PHP_INI_DIR/conf.d/"

RUN mkdir -p /var/www/.symfony5 \
    && mkdir -p /var/www/apps \
    && chown -R www-data:www-data /var/www/.symfony5 /var/www/apps

RUN apt-get install -y iputils-ping

WORKDIR /var/www/apps/fibonacci
