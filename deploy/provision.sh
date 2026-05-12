#!/usr/bin/env bash
# Reeni CMS — One-shot provisioning script for Oracle Cloud Always Free A1 (Ubuntu 22.04 ARM)
# Run AS THE UBUNTU USER (sudo where needed). Idempotent — safe to re-run.

set -euo pipefail

APP_USER="ubuntu"
APP_DIR="/var/www/reeni-cms"
PHP_VERSION="8.4"
NODE_VERSION="20"
DB_NAME="reeni_cms"
DB_USER="reeni"
LOG() { echo -e "\n\033[1;35m▶ $*\033[0m"; }

# ─────────────────────────────────────────────────────────────────────
LOG "1. System update"
sudo apt-get update -y
sudo apt-get upgrade -y

# ─────────────────────────────────────────────────────────────────────
LOG "2. Base packages"
sudo apt-get install -y software-properties-common curl unzip git ufw fail2ban supervisor \
    jpegoptim optipng pngquant gifsicle webp libavif-bin

# ─────────────────────────────────────────────────────────────────────
LOG "3. Add PHP PPA + install PHP $PHP_VERSION"
sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get update -y
sudo apt-get install -y \
    php${PHP_VERSION}-cli php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-mysql php${PHP_VERSION}-redis \
    php${PHP_VERSION}-gd php${PHP_VERSION}-curl \
    php${PHP_VERSION}-xml php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-zip php${PHP_VERSION}-intl \
    php${PHP_VERSION}-bcmath php${PHP_VERSION}-opcache \
    php${PHP_VERSION}-imagick php${PHP_VERSION}-sqlite3

# ─────────────────────────────────────────────────────────────────────
LOG "4. Composer 2"
if ! command -v composer >/dev/null; then
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    sudo chmod +x /usr/local/bin/composer
fi

# ─────────────────────────────────────────────────────────────────────
LOG "5. Node $NODE_VERSION via NodeSource"
if ! command -v node >/dev/null || [[ "$(node -v | cut -dv -f2 | cut -d. -f1)" -lt "$NODE_VERSION" ]]; then
    curl -fsSL "https://deb.nodesource.com/setup_${NODE_VERSION}.x" | sudo -E bash -
    sudo apt-get install -y nodejs
fi

# ─────────────────────────────────────────────────────────────────────
LOG "6. MySQL 8"
sudo apt-get install -y mysql-server
sudo systemctl enable --now mysql

# ─────────────────────────────────────────────────────────────────────
LOG "7. Redis 7"
sudo apt-get install -y redis-server
sudo systemctl enable --now redis-server

# ─────────────────────────────────────────────────────────────────────
LOG "8. Nginx"
sudo apt-get install -y nginx
sudo systemctl enable --now nginx

# ─────────────────────────────────────────────────────────────────────
LOG "9. Cloudflare Tunnel (cloudflared)"
if ! command -v cloudflared >/dev/null; then
    curl -L --output /tmp/cloudflared.deb \
        "https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-arm64.deb"
    sudo dpkg -i /tmp/cloudflared.deb
fi

# ─────────────────────────────────────────────────────────────────────
LOG "10. UFW firewall (block inbound except SSH; Cloudflare Tunnel handles HTTP)"
sudo ufw allow OpenSSH
sudo ufw --force enable

# ─────────────────────────────────────────────────────────────────────
LOG "11. fail2ban (basic SSH protection)"
sudo systemctl enable --now fail2ban

# ─────────────────────────────────────────────────────────────────────
LOG "12. App directory & permissions"
sudo mkdir -p "$APP_DIR"
sudo chown -R "$APP_USER":"$APP_USER" "$APP_DIR"

# ─────────────────────────────────────────────────────────────────────
LOG "13. PHP-FPM tuning for 24 GB ARM"
PHP_FPM_CONF="/etc/php/${PHP_VERSION}/fpm/pool.d/www.conf"
sudo sed -i 's/^pm = .*/pm = dynamic/' "$PHP_FPM_CONF"
sudo sed -i 's/^pm.max_children = .*/pm.max_children = 50/' "$PHP_FPM_CONF"
sudo sed -i 's/^pm.start_servers = .*/pm.start_servers = 8/' "$PHP_FPM_CONF"
sudo sed -i 's/^pm.min_spare_servers = .*/pm.min_spare_servers = 5/' "$PHP_FPM_CONF"
sudo sed -i 's/^pm.max_spare_servers = .*/pm.max_spare_servers = 15/' "$PHP_FPM_CONF"

# OPcache tuning
PHP_INI="/etc/php/${PHP_VERSION}/fpm/php.ini"
sudo sed -i 's/^;\?opcache.enable=.*/opcache.enable=1/' "$PHP_INI"
sudo sed -i 's/^;\?opcache.memory_consumption=.*/opcache.memory_consumption=256/' "$PHP_INI"
sudo sed -i 's/^;\?opcache.max_accelerated_files=.*/opcache.max_accelerated_files=30000/' "$PHP_INI"
sudo sed -i 's/^;\?opcache.validate_timestamps=.*/opcache.validate_timestamps=0/' "$PHP_INI"
sudo systemctl restart "php${PHP_VERSION}-fpm"

# ─────────────────────────────────────────────────────────────────────
LOG "14. 4 GB swap (in case MySQL gets greedy)"
if [[ ! -f /swapfile ]]; then
    sudo fallocate -l 4G /swapfile
    sudo chmod 600 /swapfile
    sudo mkswap /swapfile
    sudo swapon /swapfile
    echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab
fi

# ─────────────────────────────────────────────────────────────────────
LOG "✅ Provisioning complete."

cat <<EOF

═══════════════════════════════════════════════════════════════════
NEXT STEPS — these need YOU to do manually:

  1. Set MySQL root password & create DB:
       sudo mysql_secure_installation
       sudo mysql -e "CREATE DATABASE ${DB_NAME};"
       sudo mysql -e "CREATE USER '${DB_USER}'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_HERE';"
       sudo mysql -e "GRANT ALL ON ${DB_NAME}.* TO '${DB_USER}'@'localhost'; FLUSH PRIVILEGES;"

  2. Set up Cloudflare Tunnel:
       cloudflared tunnel login        # browser-based, opens auth URL
       cloudflared tunnel create reeni-cms
       # In Cloudflare Zero Trust dashboard, map your *.dpdns.org hostname → http://localhost:80
       sudo cloudflared service install <YOUR-TUNNEL-TOKEN>
       sudo systemctl enable --now cloudflared

  3. Clone & deploy your app (see deploy/deploy.sh):
       sudo -u ${APP_USER} git clone https://github.com/YOUR-USER/reeni-cms.git ${APP_DIR}
       cd ${APP_DIR}
       cp .env.example .env  # fill in DB credentials, Brevo SMTP, R2 keys
       ./deploy/deploy.sh

  4. Install systemd Horizon service (queue worker):
       sudo cp ${APP_DIR}/deploy/horizon.service /etc/systemd/system/
       sudo systemctl enable --now horizon

  5. Install nginx site:
       sudo cp ${APP_DIR}/deploy/nginx.conf /etc/nginx/sites-available/reeni-cms
       sudo ln -s /etc/nginx/sites-available/reeni-cms /etc/nginx/sites-enabled/
       sudo rm -f /etc/nginx/sites-enabled/default
       sudo nginx -t && sudo systemctl reload nginx

  6. Cron for Laravel scheduler:
       (sudo crontab -u ${APP_USER} -l 2>/dev/null; echo '* * * * * cd ${APP_DIR} && php artisan schedule:run >> /dev/null 2>&1') | sudo crontab -u ${APP_USER} -

  7. Set up UptimeRobot (https://uptimerobot.com — free) to ping
     https://your-domain.dpdns.org/health every 5 min — this prevents
     Oracle from reclaiming the VM after 7 days of idle CPU.
═══════════════════════════════════════════════════════════════════
EOF
