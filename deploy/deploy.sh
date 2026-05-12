#!/usr/bin/env bash
# Reeni CMS — Deploy script. Run from the project root on the production server.
# Idempotent. Atomic-ish: writes new build, then runs migrations + restarts services.

set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/reeni-cms}"
cd "$APP_DIR"

LOG() { echo -e "\n\033[1;36m▶ $*\033[0m"; }

LOG "1. Maintenance mode ON"
php artisan down --render="errors::503" --retry=15 || true

LOG "2. Pull latest changes"
git pull --ff-only

LOG "3. Install PHP deps"
composer install --no-dev --optimize-autoloader --no-interaction

LOG "4. Install + build JS/CSS"
npm ci
npm run build

LOG "5. Run migrations"
php artisan migrate --force

LOG "6. Clear & cache framework artifacts"
php artisan optimize:clear
php artisan optimize
php artisan filament:cache-components || true
php artisan icons:cache || true

LOG "7. Storage symlink (idempotent)"
[[ -L public/storage ]] || php artisan storage:link

LOG "8. Restart workers + PHP-FPM"
sudo systemctl restart horizon || true
sudo systemctl reload php8.4-fpm

LOG "9. Maintenance mode OFF"
php artisan up

LOG "✅ Deploy complete."
