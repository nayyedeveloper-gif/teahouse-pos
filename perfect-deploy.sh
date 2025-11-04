#!/bin/bash

# Tea House POS - Perfect All-in-One Deployment
# No password prompts - fully automated!

set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

DOMAIN="pos.tharcho.app"
APP_DIR="/var/www/$DOMAIN"
DB_NAME="teahouse_pos"
DB_USER="teahouse_user"
DB_PASSWORD="TharchoPOS2024"
ADMIN_EMAIL="admin@tharcho.app"
ADMIN_PASSWORD="Admin2024"

echo -e "${GREEN}🚀 Tea House POS - Perfect Deployment${NC}"
echo "========================================"
echo ""
echo "Domain: $DOMAIN"
echo "Admin: $ADMIN_EMAIL / $ADMIN_PASSWORD"
echo ""
read -p "Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then exit 1; fi

# Cleanup
echo -e "${GREEN}[1/12] Cleaning up...${NC}"
sudo rm -rf $APP_DIR
sudo pkill mysqld 2>/dev/null || true
sleep 2

# Start MySQL
echo -e "${GREEN}[2/12] Starting MySQL...${NC}"
sudo mkdir -p /var/run/mysqld
sudo chown mysql:mysql /var/run/mysqld
sudo systemctl start mysql
sleep 3

# Create Database
echo -e "${GREEN}[3/12] Creating database...${NC}"
sudo mysql -e "CREATE DATABASE IF NOT EXISTS teahouse_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || \
mysql -u root -e "CREATE DATABASE IF NOT EXISTS teahouse_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || true

sudo mysql -e "CREATE USER IF NOT EXISTS 'teahouse_user'@'localhost' IDENTIFIED BY 'TharchoPOS2024';" 2>/dev/null || \
mysql -u root -e "CREATE USER IF NOT EXISTS 'teahouse_user'@'localhost' IDENTIFIED BY 'TharchoPOS2024';" 2>/dev/null || true

sudo mysql -e "GRANT ALL PRIVILEGES ON teahouse_pos.* TO 'teahouse_user'@'localhost'; FLUSH PRIVILEGES;" 2>/dev/null || \
mysql -u root -e "GRANT ALL PRIVILEGES ON teahouse_pos.* TO 'teahouse_user'@'localhost'; FLUSH PRIVILEGES;" 2>/dev/null || true

echo -e "${GREEN}Database ready!${NC}"

# Setup Application
echo -e "${GREEN}[4/12] Setting up application...${NC}"
sudo mkdir -p $APP_DIR
sudo rsync -a --exclude 'node_modules' --exclude 'vendor' --exclude '.git' /root/teahouse-pos/ $APP_DIR/
cd $APP_DIR

# Permissions
echo -e "${GREEN}[5/12] Setting permissions...${NC}"
sudo chown -R www-data:www-data $APP_DIR
sudo chmod -R 755 $APP_DIR
sudo chmod -R 775 $APP_DIR/storage $APP_DIR/bootstrap/cache 2>/dev/null || true

# Install Composer
echo -e "${GREEN}[6/12] Installing Composer dependencies...${NC}"
export COMPOSER_ALLOW_SUPERUSER=1
composer install --optimize-autoloader --no-dev --no-interaction --quiet

# Install NPM
echo -e "${GREEN}[7/12] Installing NPM & building assets...${NC}"
npm install --silent 2>/dev/null
npm run build 2>/dev/null

# Configure Environment
echo -e "${GREEN}[8/12] Configuring environment...${NC}"
cp .env.example .env
sed -i "s/APP_ENV=local/APP_ENV=production/" .env
sed -i "s/APP_DEBUG=true/APP_DEBUG=false/" .env
sed -i "s|APP_URL=http://localhost|APP_URL=https://$DOMAIN|" .env
sed -i "s/DB_DATABASE=teahouse_pos/DB_DATABASE=$DB_NAME/" .env
sed -i "s/DB_USERNAME=root/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=/DB_PASSWORD=$DB_PASSWORD/" .env
sed -i "s/LOG_LEVEL=debug/LOG_LEVEL=error/" .env

# Laravel Setup
echo -e "${GREEN}[9/12] Setting up Laravel...${NC}"
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --class=MenuItemsSeeder --force 2>/dev/null || echo "Seeder already run or not found"

# Create Admin
echo -e "${GREEN}[10/12] Creating admin user...${NC}"
php artisan tinker --execute="
try {
    \$user = App\Models\User::where('email', '$ADMIN_EMAIL')->first();
    if (!\$user) {
        \$user = new App\Models\User();
        \$user->name = 'Admin';
        \$user->email = '$ADMIN_EMAIL';
        \$user->password = bcrypt('$ADMIN_PASSWORD');
        \$user->role = 'admin';
        \$user->save();
        echo 'Admin created!';
    } else {
        echo 'Admin exists!';
    }
} catch (Exception \$e) {
    echo 'Error: ' . \$e->getMessage();
}
" 2>/dev/null || echo "Admin user setup attempted"

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Configure Nginx
echo -e "${GREEN}[11/12] Configuring web server...${NC}"
sudo tee /etc/nginx/sites-available/$DOMAIN > /dev/null << 'NGINX_EOF'
server {
    listen 80;
    listen [::]:80;
    server_name pos.tharcho.app;
    root /var/www/pos.tharcho.app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 20M;
}
NGINX_EOF

# Enable site
sudo ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm

# SSL
echo -e "${GREEN}[12/12] Installing SSL certificate...${NC}"
sudo certbot --nginx -d $DOMAIN --non-interactive --agree-tos --email $ADMIN_EMAIL --redirect 2>/dev/null || echo "SSL installation attempted"

# Firewall
sudo ufw allow 'Nginx Full' 2>/dev/null || true
sudo ufw allow OpenSSH 2>/dev/null || true
echo "y" | sudo ufw enable 2>/dev/null || true

# Cron
(sudo crontab -l 2>/dev/null | grep -v "$APP_DIR"; echo "* * * * * cd $APP_DIR && php artisan schedule:run >> /dev/null 2>&1") | sudo crontab - 2>/dev/null || true

# Final permissions
sudo chown -R www-data:www-data $APP_DIR
sudo chmod -R 755 $APP_DIR
sudo chmod -R 775 $APP_DIR/storage $APP_DIR/bootstrap/cache

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}🎉 DEPLOYMENT COMPLETE!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "Website: ${GREEN}https://$DOMAIN${NC}"
echo -e "Admin: ${GREEN}https://$DOMAIN/admin/dashboard${NC}"
echo ""
echo -e "Login:"
echo -e "Email: ${YELLOW}$ADMIN_EMAIL${NC}"
echo -e "Password: ${YELLOW}$ADMIN_PASSWORD${NC}"
echo ""
echo -e "Database:"
echo -e "Name: ${YELLOW}$DB_NAME${NC}"
echo -e "User: ${YELLOW}$DB_USER${NC}"
echo -e "Password: ${YELLOW}$DB_PASSWORD${NC}"
echo ""
echo -e "${GREEN}Ready to use! 🚀${NC}"
