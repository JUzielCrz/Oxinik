FROM php:7.4-cli

# System deps + PHP extensions needed by Laravel 7 and DOMPDF.
#
# PHP 7.4 is legacy and its Debian 11 base image uses package indexes that
# can reference packages already removed from the live security mirror. Use
# the snapshot shipped in the base image comments so builds remain repeatable.
RUN sed -i \
      's|http://deb.debian.org/debian-security bullseye-security|https://snapshot.debian.org/archive/debian-security/20221114T000000Z bullseye-security|; \
       s|http://deb.debian.org/debian bullseye|https://snapshot.debian.org/archive/debian/20221114T000000Z bullseye|g' \
      /etc/apt/sources.list \
  && rm -rf /var/lib/apt/lists/* \
  && apt-get -o Acquire::Check-Valid-Until=false update \
  && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo_mysql mbstring zip xml gd bcmath \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
# Ensure classmap paths exist during install
RUN mkdir -p database/seeds database/factories \
  && COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts

COPY . .

RUN if [ ! -f .env ] && [ -f .env_example ]; then cp .env_example .env; fi \
  && mkdir -p storage/logs \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
  && COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize --no-interaction \
  && php artisan package:discover --ansi \
  && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8086

USER www-data
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8086"]
