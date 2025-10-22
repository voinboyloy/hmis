FROM php:8.2-fpm

# system deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zlib1g-dev libicu-dev \
    && docker-php-ext-install zip intl pdo pdo_mysql

# install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy composer files first for caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress || true

COPY . .

# set permissions (adjust as needed)
RUN chown -R www-data:www-data /var/www/html
