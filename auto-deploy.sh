#!/bin/bash

# Tea House POS - Automatic Deployment Script
# No password prompts - fully automated!

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Configuration
DOMAIN="pos.tharcho.app"
APP_DIR="/var/www/$DOMAIN"
DB_NAME="teahouse_pos"
DB_USER="teahouse_user"
DB_PASSWORD="TharchoPOS2024"
MYSQL_ROOT_PASSWORD="RootMySQL2024"
ADMIN_EMAIL="admin@tharcho.app"
ADMIN_PASSWORD="Admin2024"

echo -e "${GREEN}🚀 Tea House POS - Automatic Deployment${NC}"
echo "=========================================="
echo ""
echo "Domain: $DOMAIN"
echo "Database: $DB_NAME"
echo "Admin: $ADMIN_EMAIL"
echo ""
read -p "Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

# Step 1: Reset MySQL Password
echo -e "${GREEN}[1/15] Resetting MySQL password...${NC}"
sudo systemctl stop mysql || true
sleep 2

sudo pkill mysqld || true
sleep 2

sudo mysqld_safe --skip-grant-tables &
SAFE_PID=$!
sleep 8

mysql -u root << EOF
FLUSH PRIVILEGES;
ALTER USER 'root'@'localhost' IDENTIFIED BY '$MYSQL_ROOT_PASSWORD';
FLUSH PRIVILEGES;
EOF

sudo pkill mysqld
sleep 3
sudo systemctl start mysql
sleep 3

echo -e "${GREEN}MySQL password reset complete!${NC}"

# Step 2: Create Database
echo -e "${GREEN}[2/15] Creating database...${NC}"
mysql -u root -p$MYSQL_ROOT_PASSWORD << EOF
CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
EOF

echo -e "${GREEN}Database created!${NC}"

# Step 3: Create Application Directory
echo -e "${GREEN}[3/15] Setting up application directory...${NC}"
sudo mkdir -p $APP_DIR
sudo cp -r /root/teahouse-pos/* $APP_DIR/
cd $APP_DIR

# Step 4: Set Permissions
echo -e "${GREEN}[4/15] Setting permissions...${NC}"
sudo chown -R www-data:www-data $APP_DIR
sudo chmod -R 755 $APP_DIR
sudo chmod -R 775 $APP_DIR/storage $APP_DIR/bootstrap/cache

# Step 5: Install Composer Dependencies
echo -e "${GREEN}[5/15] Installing Composer dependencies...${NC}"
composer install --optimize-autoloader --no-dev --no-interaction

# Step 6: Install NPM Dependencies
echo -e "${GREEN}[6/15] Installing NPM dependencies...${NC}"
npm install --silent

# Step 7: Build Assets
echo -e "${GREEN}[7/15] Building assets...${NC}"
npm run build

# Step 8: Configure Environment
echo -e "${GREEN}[8/15] Configuring environment...${NC}"
cp .env.example .env

# Update .env file
sed -i "s/APP_ENV=local/APP_ENV=production/" .env
sed -i "s/APP_DEBUG=true/APP_DEBUG=false/" .env
sed -i "s|APP_URL=http://localhost|APP_URL=https://$DOMAIN|" .env
sed -i "s/DB_DATABASE=teahouse_pos/DB_DATABASE=$DB_NAME/" .env
sed -i "s/DB_USERNAME=root/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=/DB_PASSWORD=$DB_PASSWORD/" .env
sed -i "s/LOG_LEVEL=debug/LOG_LEVEL=error/" .env

# Step 9: Generate Application Key
echo -e "${GREEN}[9/15] Generating application key...${NC}"
php artisan key:generate --force

# Step 10: Run Migrations
echo -e "${GREEN}[10/15] Running migrations...${NC}"
php artisan migrate --force

# Step 11: Seed Database
echo -e "${GREEN}[11/15] Seeding database...${NC}"
php artisan db:seed --class=MenuItemsSeeder --force

# Step 12: Create Admin User
echo -e "${GREEN}[12/15] Creating admin user...${NC}"
php artisan tinker --execute="
\$user = App\Models\User::where('email', '$ADMIN_EMAIL')->first();
if (!\$user) {
    \$user = new App\Models\User();
    \$user->name = 'Admin';
    \$user->email = '$ADMIN_EMAIL';
    \$user->password = bcrypt('$ADMIN_PASSWORD');
    \$user->role = 'admin';
    \$user->save();
    echo 'Admin user created!';
} else {
    echo 'Admin user already exists!';
}
"

# Step 13: Optimize Application
echo -e "${GREEN}[13/15] Optimizing application...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Step 14: Configure Nginx
echo -e "${GREEN}[14/15] Configuring Nginx...${NC}"
sudo tee /etc/nginx/sites-available/$DOMAIN > /dev/null << 'NGINX_EOF'
server {
    listen 80;
    listen [::]:80;
    server_name DOMAIN_PLACEHOLDER;
    root APP_DIR_PLACEHOLDER/public;

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

# Replace placeholders
sudo sed -i "s|DOMAIN_PLACEHOLDER|$DOMAIN|g" /etc/nginx/sites-available/$DOMAIN
sudo sed -i "s|APP_DIR_PLACEHOLDER|$APP_DIR|g" /etc/nginx/sites-available/$DOMAIN

# Enable site
sudo ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm

# Step 15: Install SSL Certificate
echo -e "${GREEN}[15/15] Installing SSL certificate...${NC}"
sudo certbot --nginx -d $DOMAIN --non-interactive --agree-tos --email $ADMIN_EMAIL --redirect

# Setup Firewall
echo -e "${GREEN}Setting up firewall...${NC}"
sudo ufw allow 'Nginx Full' > /dev/null 2>&1 || true
sudo ufw allow OpenSSH > /dev/null 2>&1 || true
echo "y" | sudo ufw enable > /dev/null 2>&1 || true

# Setup Cron
echo -e "${GREEN}Setting up cron job...${NC}"
(sudo crontab -l 2>/dev/null | grep -v "$APP_DIR"; echo "* * * * * cd $APP_DIR && php artisan schedule:run >> /dev/null 2>&1") | sudo crontab -

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
echo -e "Admin Panel: ${GREEN}https://$DOMAIN/admin/dashboard${NC}"
echo ""
echo -e "Login Credentials:"
echo -e "Email: ${YELLOW}$ADMIN_EMAIL${NC}"
echo -e "Password: ${YELLOW}$ADMIN_PASSWORD${NC}"
echo ""
echo -e "Database Credentials:"
echo -e "MySQL Root Password: ${YELLOW}$MYSQL_ROOT_PASSWORD${NC}"
echo -e "Database: ${YELLOW}$DB_NAME${NC}"
echo -e "DB User: ${YELLOW}$DB_USER${NC}"
echo -e "DB Password: ${YELLOW}$DB_PASSWORD${NC}"
echo ""
echo -e "${GREEN}Ready to use! 🚀${NC}"
echo ""
