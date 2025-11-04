#!/bin/bash

# Tea House POS - Quick Deployment Script
# Domain: pos.tharcho.app

set -e

echo "🚀 Tea House POS - Quick Deployment"
echo "===================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
DOMAIN="pos.tharcho.app"
APP_DIR="/var/www/$DOMAIN"
DB_NAME="teahouse_pos"
DB_USER="teahouse_user"

echo -e "${YELLOW}This script will deploy Tea House POS to $DOMAIN${NC}"
echo ""
read -p "Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

# Step 1: Update System
echo -e "${GREEN}[1/10] Updating system...${NC}"
apt update && apt upgrade -y

# Step 2: Install PHP
echo -e "${GREEN}[2/10] Installing PHP 8.2...${NC}"
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml \
php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-cli

# Step 3: Install MySQL
echo -e "${GREEN}[3/10] Installing MySQL...${NC}"
apt install -y mysql-server

# Step 4: Install Nginx
echo -e "${GREEN}[4/10] Installing Nginx...${NC}"
apt install -y nginx

# Step 5: Install Composer
echo -e "${GREEN}[5/10] Installing Composer...${NC}"
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Step 6: Install Node.js
echo -e "${GREEN}[6/10] Installing Node.js...${NC}"
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt install -y nodejs

# Step 7: Install Git & Certbot
echo -e "${GREEN}[7/10] Installing Git & Certbot...${NC}"
apt install -y git certbot python3-certbot-nginx

# Step 8: Setup Database
echo -e "${GREEN}[8/10] Setting up database...${NC}"
echo "Please enter MySQL root password:"
read -s MYSQL_ROOT_PASSWORD
echo "Please enter new database password for $DB_USER:"
read -s DB_PASSWORD

mysql -u root -p$MYSQL_ROOT_PASSWORD <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
MYSQL_SCRIPT

echo -e "${GREEN}Database created successfully!${NC}"

# Step 9: Create Application Directory
echo -e "${GREEN}[9/10] Creating application directory...${NC}"
mkdir -p $APP_DIR
cd $APP_DIR

echo ""
echo -e "${YELLOW}Application directory created: $APP_DIR${NC}"
echo -e "${YELLOW}Please upload your application files to this directory.${NC}"
echo ""
echo "You can use SCP:"
echo "  scp -r /path/to/teahouse-pos/* root@server-ip:$APP_DIR/"
echo ""
echo "Or Git:"
echo "  cd $APP_DIR"
echo "  git clone https://github.com/yourusername/teahouse-pos.git ."
echo ""
read -p "Press enter when files are uploaded..."

# Step 10: Setup Application
echo -e "${GREEN}[10/10] Setting up application...${NC}"

# Set permissions
chown -R www-data:www-data $APP_DIR
chmod -R 755 $APP_DIR
chmod -R 775 $APP_DIR/storage $APP_DIR/bootstrap/cache

# Install dependencies
cd $APP_DIR
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Configure environment
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Please configure .env file:"
    echo "  DB_DATABASE=$DB_NAME"
    echo "  DB_USERNAME=$DB_USER"
    echo "  DB_PASSWORD=$DB_PASSWORD"
    echo "  APP_URL=https://$DOMAIN"
    echo ""
    read -p "Press enter when .env is configured..."
fi

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Seed database
echo "Do you want to seed the database with menu items? (y/n)"
read -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:seed --class=MenuItemsSeeder --force
fi

# Create admin user
echo ""
echo "Creating admin user..."
echo "Enter admin email:"
read ADMIN_EMAIL
echo "Enter admin password:"
read -s ADMIN_PASSWORD

php artisan tinker <<EOF
\$user = new App\Models\User();
\$user->name = 'Admin';
\$user->email = '$ADMIN_EMAIL';
\$user->password = bcrypt('$ADMIN_PASSWORD');
\$user->role = 'admin';
\$user->save();
exit
EOF

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Configure Nginx
echo -e "${GREEN}Configuring Nginx...${NC}"
cat > /etc/nginx/sites-available/$DOMAIN <<'NGINX_CONFIG'
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
NGINX_CONFIG

# Replace placeholders
sed -i "s|DOMAIN_PLACEHOLDER|$DOMAIN|g" /etc/nginx/sites-available/$DOMAIN
sed -i "s|APP_DIR_PLACEHOLDER|$APP_DIR|g" /etc/nginx/sites-available/$DOMAIN

# Enable site
ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test and restart Nginx
nginx -t
systemctl restart nginx

# Setup SSL
echo -e "${GREEN}Setting up SSL certificate...${NC}"
certbot --nginx -d $DOMAIN --non-interactive --agree-tos --email $ADMIN_EMAIL

# Setup firewall
echo -e "${GREEN}Configuring firewall...${NC}"
ufw allow 'Nginx Full'
ufw allow OpenSSH
echo "y" | ufw enable

# Setup cron
echo -e "${GREEN}Setting up cron jobs...${NC}"
(crontab -l 2>/dev/null; echo "* * * * * cd $APP_DIR && php artisan schedule:run >> /dev/null 2>&1") | crontab -

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}🎉 DEPLOYMENT COMPLETE!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "Website: ${GREEN}https://$DOMAIN${NC}"
echo -e "Admin: ${GREEN}https://$DOMAIN/admin/dashboard${NC}"
echo -e "Email: ${GREEN}$ADMIN_EMAIL${NC}"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Visit https://$DOMAIN and login"
echo "2. Configure settings in Admin panel"
echo "3. Create user accounts"
echo "4. Test all features"
echo "5. Train staff"
echo "6. Go live!"
echo ""
echo -e "${GREEN}Good luck! 🚀${NC}"
