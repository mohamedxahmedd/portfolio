# syntax=docker/dockerfile:1.6
# ============================================================================
#  Mohamed's Portfolio — production Dockerfile
#
#  Works for Docker hosting such as Back4app Containers or Render Web Service.
#
#  Three-stage build:
#    1) assets   — compiles Vite assets with Node 20.
#    2) vendor   — installs production Composer dependencies.
#    3) runtime  — nginx + PHP-FPM via richarvey/nginx-php-fpm.
#
#  Runtime steps:
#    - storage:link
#    - migrate --force
#    - config:cache
#    - route:cache
#    - view:cache
#    - /start.sh
# ============================================================================


# ─────────────────────────────────────────────────────────────────────────────
# 1) assets stage — build Vite output with Node 20
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
# 2) vendor stage — production Composer dependencies
# ─────────────────────────────────────────────────────────────────────────────
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --prefer-dist


# ─────────────────────────────────────────────────────────────────────────────
# 3) runtime stage — nginx + PHP-FPM
# ─────────────────────────────────────────────────────────────────────────────
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

COPY . .

COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload \
    --optimize \
    --no-dev \
    --classmap-authoritative \
    --no-interaction

RUN chown -R nginx:nginx storage bootstrap/cache \
    && find storage -type d -exec chmod 775 {} \; \
    && find storage -type f -exec chmod 664 {} \; \
    && chmod -R 775 bootstrap/cache

ENV WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    RUN_SCRIPTS=0

EXPOSE 80

CMD php artisan storage:link 2>/dev/null || true ; \
    php artisan migrate --force --no-interaction && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    /start.sh