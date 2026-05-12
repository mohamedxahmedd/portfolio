# syntax=docker/dockerfile:1.6

# ─────────────────────────────────────────────────────────────────────────────
# 1) assets stage — build Vite output
# ─────────────────────────────────────────────────────────────────────────────
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --no-audit --no-fund

COPY vite.config.js ./
COPY resources ./resources
COPY public/themes ./public/themes

RUN npm run build


# ─────────────────────────────────────────────────────────────────────────────
# 2) vendor stage — Composer dependencies with PHP 8.4
# ─────────────────────────────────────────────────────────────────────────────
FROM php:8.4-cli-alpine AS vendor

WORKDIR /app

RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    mysql-client \
    $PHPIZE_DEPS \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl exif pcntl pdo_mysql zip bcmath opcache \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

COPY composer.json composer.lock ./

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --prefer-dist


# ─────────────────────────────────────────────────────────────────────────────
# 3) runtime stage — PHP 8.4 + Apache
# ─────────────────────────────────────────────────────────────────────────────
FROM php:8.4-apache-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    icu-libs \
    oniguruma-dev \
    libzip-dev \
    mysql-client \
    $PHPIZE_DEPS \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl exif pcntl pdo_mysql zip bcmath opcache \
    && a2enmod rewrite

COPY . .

COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN php artisan package:discover --ansi || true \
    && php artisan optimize:clear || true

RUN chown -R www-data:www-data storage bootstrap/cache \
    && find storage -type d -exec chmod 775 {} \; \
    && find storage -type f -exec chmod 664 {} \; \
    && chmod -R 775 bootstrap/cache

RUN sed -i 's!/var/www/localhost/htdocs!/var/www/html/public!g' /etc/apache2/httpd.conf \
    && sed -i 's!AllowOverride None!AllowOverride All!g' /etc/apache2/httpd.conf

EXPOSE 80

CMD php artisan storage:link 2>/dev/null || true ; \
    php artisan migrate --force --no-interaction && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    httpd -D FOREGROUND