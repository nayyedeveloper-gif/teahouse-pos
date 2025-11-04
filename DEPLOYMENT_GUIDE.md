# 🚀 DEPLOYMENT GUIDE - Tea House POS

## 📋 **DEPLOYMENT INFORMATION**

**Domain:** pos.tharcho.app  
**Server:** VPS (Ubuntu/Debian recommended)  
**Stack:** Laravel 11, PHP 8.2+, MySQL 8.0+, Nginx  
**Date:** November 4, 2025

---

## ✅ **PRE-DEPLOYMENT CHECKLIST**

### **1. Server Requirements:**
```
✅ Ubuntu 20.04+ or Debian 11+
✅ PHP 8.2 or higher
✅ MySQL 8.0 or MariaDB 10.3+
✅ Nginx or Apache
✅ Composer 2.x
✅ Node.js 18+ & NPM
✅ Git
✅ SSL Certificate (Let's Encrypt)
```

### **2. PHP Extensions:**
```
✅ php8.2-fpm
✅ php8.2-mysql
✅ php8.2-mbstring
✅ php8.2-xml
✅ php8.2-bcmath
✅ php8.2-curl
✅ php8.2-zip
✅ php8.2-gd
✅ php8.2-intl
```

---

## 🔧 **STEP 1: SERVER SETUP**

### **Connect to Server:**
```bash
ssh root@your-server-ip
```

### **Update System:**
```bash
apt update && apt upgrade -y
```

### **Install Required Packages:**
```bash
# Add PHP repository
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update

# Install PHP 8.2 and extensions
apt install -y php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml \
php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-cli

# Install MySQL
apt install -y mysql-server

# Install Nginx
apt install -y nginx

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt install -y nodejs

# Install Git
apt install -y git

# Install Certbot for SSL
apt install -y certbot python3-certbot-nginx
```

---

## 🗄️ **STEP 2: DATABASE SETUP**

### **Secure MySQL:**
```bash
mysql_secure_installation
```

### **Create Database:**
```bash
mysql -u root -p
```

```sql
CREATE DATABASE teahouse_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'teahouse_user'@'localhost' IDENTIFIED BY 'your_strong_password_here';
GRANT ALL PRIVILEGES ON teahouse_pos.* TO 'teahouse_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## 📁 **STEP 3: DEPLOY APPLICATION**

### **Create Directory:**
```bash
mkdir -p /var/www/pos.tharcho.app
cd /var/www/pos.tharcho.app
```

### **Clone Repository (Option 1):**
```bash
# If using Git repository
git clone https://github.com/yourusername/teahouse-pos.git .
```

### **Upload Files (Option 2):**
```bash
# From your local machine
scp -r /Users/developer/Downloads/teahouse-pos/* root@your-server-ip:/var/www/pos.tharcho.app/
```

### **Set Permissions:**
```bash
cd /var/www/pos.tharcho.app
chown -R www-data:www-data .
chmod -R 755 .
chmod -R 775 storage bootstrap/cache
```

### **Install Dependencies:**
```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies
npm install

# Build assets
npm run build
```

---

## ⚙️ **STEP 4: CONFIGURE ENVIRONMENT**

### **Create .env File:**
```bash
cp .env.example .env
nano .env
```

### **Update .env Configuration:**
```env
APP_NAME="Tea House POS"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://pos.tharcho.app

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teahouse_pos
DB_USERNAME=teahouse_user
DB_PASSWORD=your_strong_password_here

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Mail Configuration (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tharcho.app
MAIL_FROM_NAME="${APP_NAME}"
```

### **Generate Application Key:**
```bash
php artisan key:generate
```

### **Run Migrations:**
```bash
php artisan migrate --force
```

### **Seed Database (Optional):**
```bash
# Seed menu items
php artisan db:seed --class=MenuItemsSeeder

# Or seed everything
php artisan db:seed --force
```

### **Create Admin User:**
```bash
php artisan tinker
```

```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@tharcho.app';
$user->password = bcrypt('your_secure_password');
$user->role = 'admin';
$user->save();
exit
```

### **Optimize Application:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 🌐 **STEP 5: NGINX CONFIGURATION**

### **Create Nginx Config:**
```bash
nano /etc/nginx/sites-available/pos.tharcho.app
```

### **Add Configuration:**
```nginx
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

    # Increase upload size for images
    client_max_body_size 20M;
}
```

### **Enable Site:**
```bash
ln -s /etc/nginx/sites-available/pos.tharcho.app /etc/nginx/sites-enabled/
```

### **Test Nginx:**
```bash
nginx -t
```

### **Restart Nginx:**
```bash
systemctl restart nginx
```

---

## 🔒 **STEP 6: SSL CERTIFICATE**

### **Install SSL Certificate:**
```bash
certbot --nginx -d pos.tharcho.app
```

### **Follow Prompts:**
```
1. Enter email address
2. Agree to terms
3. Choose to redirect HTTP to HTTPS (recommended)
```

### **Auto-renewal Test:**
```bash
certbot renew --dry-run
```

---

## 🔥 **STEP 7: FIREWALL SETUP**

### **Configure UFW:**
```bash
ufw allow 'Nginx Full'
ufw allow OpenSSH
ufw enable
ufw status
```

---

## 📊 **STEP 8: MONITORING & MAINTENANCE**

### **Setup Cron Jobs:**
```bash
crontab -e
```

Add:
```cron
* * * * * cd /var/www/pos.tharcho.app && php artisan schedule:run >> /dev/null 2>&1
```

### **Setup Log Rotation:**
```bash
nano /etc/logrotate.d/laravel
```

Add:
```
/var/www/pos.tharcho.app/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

### **Monitor Logs:**
```bash
# Application logs
tail -f /var/www/pos.tharcho.app/storage/logs/laravel.log

# Nginx logs
tail -f /var/log/nginx/error.log
tail -f /var/log/nginx/access.log
```

---

## ✅ **STEP 9: POST-DEPLOYMENT VERIFICATION**

### **1. Check Website:**
```
Visit: https://pos.tharcho.app
Expected: Login page loads
```

### **2. Test Login:**
```
Email: admin@tharcho.app
Password: your_secure_password
Expected: Dashboard loads
```

### **3. Check Features:**
```
✅ Admin dashboard loads
✅ Categories page works
✅ Items page works
✅ Settings page works
✅ Cashier POS loads
✅ Card management works (if enabled)
```

### **4. Test Transactions:**
```
✅ Create test order
✅ Process payment
✅ Print receipt
✅ View reports
```

---

## 🔧 **STEP 10: CONFIGURE SYSTEM SETTINGS**

### **Login as Admin:**
```
https://pos.tharcho.app/login
```

### **Configure Settings:**
```
1. Go to Settings
2. Update:
   ✅ Business name
   ✅ Upload logo
   ✅ Tax percentage
   ✅ Service charge
   ✅ Receipt settings
   ✅ Printer settings
   ✅ Card system (enable if needed)
```

### **Create Users:**
```
1. Go to Users Management
2. Create:
   ✅ Cashier accounts
   ✅ Waiter accounts (if needed)
   ✅ Kitchen accounts (if needed)
```

### **Setup Menu:**
```
1. Categories already seeded ✅
2. Items already seeded (113 items) ✅
3. Review and adjust prices if needed
4. Add/remove items as needed
```

---

## 🎯 **QUICK DEPLOYMENT SCRIPT**

Save this as `deploy.sh`:

```bash
#!/bin/bash

echo "🚀 Deploying Tea House POS..."

# Navigate to project
cd /var/www/pos.tharcho.app

# Pull latest changes (if using Git)
# git pull origin main

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Set permissions
chown -R www-data:www-data .
chmod -R 755 .
chmod -R 775 storage bootstrap/cache

# Restart services
systemctl restart php8.2-fpm
systemctl restart nginx

echo "✅ Deployment complete!"
```

Make executable:
```bash
chmod +x deploy.sh
```

---

## 🆘 **TROUBLESHOOTING**

### **Issue: 500 Internal Server Error**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Check permissions
chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### **Issue: Database Connection Failed**
```bash
# Check MySQL is running
systemctl status mysql

# Test connection
mysql -u teahouse_user -p teahouse_pos

# Check .env credentials
cat .env | grep DB_
```

### **Issue: Assets Not Loading**
```bash
# Rebuild assets
npm run build

# Check public directory
ls -la public/build

# Clear cache
php artisan view:clear
```

### **Issue: Permission Denied**
```bash
# Fix permissions
cd /var/www/pos.tharcho.app
chown -R www-data:www-data .
chmod -R 755 .
chmod -R 775 storage bootstrap/cache
```

---

## 📱 **STEP 11: MOBILE/PWA SETUP**

### **Test PWA:**
```
1. Visit https://pos.tharcho.app on mobile
2. Browser should prompt "Add to Home Screen"
3. Add to home screen
4. Open as app
5. Should work offline (basic functionality)
```

---

## 🎊 **DEPLOYMENT COMPLETE!**

### **Access Points:**
```
Main Site: https://pos.tharcho.app
Admin: https://pos.tharcho.app/admin/dashboard
Cashier: https://pos.tharcho.app/cashier/pos
Digital Signage: https://pos.tharcho.app/display/signage
```

### **Default Credentials:**
```
Email: admin@tharcho.app
Password: (set during deployment)
```

### **Next Steps:**
```
✅ Change admin password
✅ Create user accounts
✅ Configure settings
✅ Test all features
✅ Train staff
✅ Go live!
```

---

## 📞 **SUPPORT**

### **Check Status:**
```bash
# Application
php artisan about

# Services
systemctl status nginx
systemctl status php8.2-fpm
systemctl status mysql

# Disk space
df -h

# Memory
free -h
```

### **Backup Database:**
```bash
mysqldump -u teahouse_user -p teahouse_pos > backup_$(date +%Y%m%d).sql
```

### **Restore Database:**
```bash
mysql -u teahouse_user -p teahouse_pos < backup_20251104.sql
```

---

**🎉 READY TO LAUNCH!**

**Domain:** https://pos.tharcho.app  
**Status:** Production Ready ✅  
**Features:** 100% Complete ✅

**Good luck with your launch!** 🚀
