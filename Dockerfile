# syntax=docker/dockerfile:1.6
# ============================================================================
#  Mohamed's Portfolio — production Dockerfile for Render Docker Web Service.
#
#  Three-stage build:
#    1) assets   — compiles Vite (Tailwind 4 + Alpine + Livewire JS) with Node 20.
#    2) vendor   — installs production Composer dependencies (no dev packages).
#    3) runtime  — final image: nginx + PHP-FPM 8.x via richarvey/nginx-php-fpm,
#                  with the built assets and vendor folder copied in.
#
#  Runtime steps (CMD) executed each container start:
#    - storage:link  (idempotent, ignored if it already exists)
#    - migrate --force  (runs pending migrations against the production MySQL)
#    - config:cache + route:cache + view:cache  (after env vars are injected)
#    - /start.sh  (the base image's nginx + PHP-FPM supervisor)
#
#  We deliberately DO NOT run `config:cache` at build time — Render injects
#  environment variables at runtime, not build time, so caching during build
#  would bake placeholder values into bootstrap/cache/config.php.
# ============================================================================


# ─────────────────────────────────────────────────────────────────────────────
# 1) assets stage — build Vite output with Node 20
# ─────────────────────────────────────────────────────────────────────────────
FROM node:20-alpine AS assets

WORKDIR /app

# Install npm deps in a separate layer so source changes don't invalidate the cache
COPY package.json package-lock.json* ./
RUN npm ci --no-audit --no-fund

# Bring in the files Vite + Tailwind class-scanner need to build:
#   resources/    → CSS/JS source + Blade views (Tailwind `@source` paths)
#   public/themes → theme-specific assets referenced by Vite
#   vite.config.js
COPY vite.config.js ./
COPY resources ./resources
COPY public/themes ./public/themes

RUN npm run build


# ─────────────────────────────────────────────────────────────────────────────
# 2) vendor stage — production Composer dependencies
# ─────────────────────────────────────────────────────────────────────────────
FROM composer:2 AS vendor

WORKDIR /app

# `--no-scripts` is required because artisan isn't available yet (no app code copied)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --prefer-dist


# ─────────────────────────────────────────────────────────────────────────────
# 3) runtime stage — nginx + PHP-FPM (richarvey)
# ─────────────────────────────────────────────────────────────────────────────
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

# Copy the application source (vendor + build excluded via .dockerignore).
COPY . .

# Bring in the artefacts from earlier stages
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Rebuild the optimised classmap now that the full codebase is present.
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative --no-interaction

# Laravel writable dirs — keep tight perms but make sure nginx user owns them
RUN chown -R nginx:nginx storage bootstrap/cache \
    && find storage -type d -exec chmod 775 {} \; \
    && find storage -type f -exec chmod 664 {} \; \
    && chmod -R 775 bootstrap/cache

# richarvey/nginx-php-fpm runtime config
ENV WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    RUN_SCRIPTS=0

# richarvey listens on :80 — Render's Docker web service maps that to public HTTPS.
EXPOSE 80

# Boot sequence — runs every container start:
#   • storage:link  (ignored when symlink already exists)
#   • migrate       (applies any new migrations against production MySQL)
#   • config/route/view cache (with real env vars injected by Render)
#   • /start.sh     (the base image's nginx + PHP-FPM supervisor — must be last)
CMD php artisan storage:link 2>/dev/null || true ; \
    php artisan migrate --force --no-interaction ; \
    php artisan config:cache ; \
    php artisan route:cache ; \
    php artisan view:cache ; \
    /start.sh
