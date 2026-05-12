FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN if [ -f package.json ]; then npm install && npm run build; fi

RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

ENV WEBROOT=/var/www/html/public