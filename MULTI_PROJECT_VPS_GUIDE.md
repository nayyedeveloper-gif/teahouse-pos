# 🚀 MULTIPLE PROJECTS ON ONE VPS GUIDE

## ✅ **YES! You can host multiple Laravel projects on one VPS**

---

## 🎯 **METHODS TO HOST MULTIPLE PROJECTS**

### **Method 1: Subdomain (Recommended)** ⭐
```
project1.yourdomain.com → /var/www/project1
project2.yourdomain.com → /var/www/project2
```

**Pros:**
- ✅ Clean separation
- ✅ Easy SSL certificates
- ✅ Professional URLs
- ✅ Independent configurations

**Cons:**
- ⚠️ Need domain with subdomain support

---

### **Method 2: Subdirectory**
```
yourdomain.com/project1 → /var/www/project1
yourdomain.com/project2 → /var/www/project2
```

**Pros:**
- ✅ Single domain needed
- ✅ Simple setup

**Cons:**
- ❌ Laravel routing issues
- ❌ Harder to configure
- ❌ Not recommended for Laravel

---

### **Method 3: Different Ports**
```
yourdomain.com:8001 → Project 1
yourdomain.com:8002 → Project 2
```

**Pros:**
- ✅ Simple setup
- ✅ No domain needed

**Cons:**
- ❌ Unprofessional URLs
- ❌ Firewall issues
- ❌ No SSL easily
- ❌ Not recommended

---

### **Method 4: Different Domains**
```
domain1.com → Project 1
domain2.com → Project 2
```

**Pros:**
- ✅ Complete separation
- ✅ Professional
- ✅ Easy SSL

**Cons:**
- ⚠️ Need multiple domains
- ⚠️ More expensive

---

## 🎯 **RECOMMENDED: SUBDOMAIN METHOD**

### **Example Setup:**
```
pos.tharchocafe.com     → TharCho POS
admin.tharchocafe.com   → Admin Panel
api.tharchocafe.com     → API Server
```

---

## 📋 **STEP-BY-STEP SETUP (Subdomain)**

### **1. VPS Requirements:**
```
CPU:      2+ cores
RAM:      2GB+ (4GB recommended)
Storage:  20GB+ SSD
OS:       Ubuntu 22.04 LTS
```

### **2. Install Required Software:**
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Nginx
sudo apt install nginx -y

# Install PHP 8.2
sudo apt install php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml \
  php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd -y

# Install MySQL
sudo apt install mysql-server -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y

# Install Certbot (for SSL)
sudo apt install certbot python3-certbot-nginx -y
```

---

## 🗂️ **PROJECT STRUCTURE**

### **Directory Layout:**
```
/var/www/
├── project1/
│   ├── public/          # Document root
│   ├── app/
│   ├── config/
│   ├── .env
│   └── ...
│
├── project2/
│   ├── public/          # Document root
│   ├── app/
│   ├── config/
│   ├── .env
│   └── ...
│
└── shared/              # Optional: shared resources
    ├── storage/
    └── cache/
```

---

## ⚙️ **NGINX CONFIGURATION**

### **Project 1: pos.tharchocafe.com**

Create: `/etc/nginx/sites-available/pos.tharchocafe.com`

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name pos.tharchocafe.com;
    root /var/www/project1/public;

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
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### **Project 2: admin.tharchocafe.com**

Create: `/etc/nginx/sites-available/admin.tharchocafe.com`

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name admin.tharchocafe.com;
    root /var/www/project2/public;

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
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### **Enable Sites:**
```bash
# Enable project 1
sudo ln -s /etc/nginx/sites-available/pos.tharchocafe.com \
           /etc/nginx/sites-enabled/

# Enable project 2
sudo ln -s /etc/nginx/sites-available/admin.tharchocafe.com \
           /etc/nginx/sites-enabled/

# Test configuration
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

---

## 🗄️ **DATABASE SETUP**

### **Create Separate Databases:**
```bash
# Login to MySQL
sudo mysql

# Create databases
CREATE DATABASE project1_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE project2_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Create users
CREATE USER 'project1_user'@'localhost' IDENTIFIED BY 'strong_password_1';
CREATE USER 'project2_user'@'localhost' IDENTIFIED BY 'strong_password_2';

# Grant permissions
GRANT ALL PRIVILEGES ON project1_db.* TO 'project1_user'@'localhost';
GRANT ALL PRIVILEGES ON project2_db.* TO 'project2_user'@'localhost';

FLUSH PRIVILEGES;
EXIT;
```

---

## 📦 **DEPLOY PROJECTS**

### **Project 1:**
```bash
# Create directory
sudo mkdir -p /var/www/project1
cd /var/www/project1

# Upload your code (via Git, FTP, or SCP)
git clone https://github.com/yourusername/project1.git .

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Setup environment
cp .env.example .env
nano .env  # Edit database credentials

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed --force

# Set permissions
sudo chown -R www-data:www-data /var/www/project1
sudo chmod -R 755 /var/www/project1
sudo chmod -R 775 /var/www/project1/storage
sudo chmod -R 775 /var/www/project1/bootstrap/cache

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Project 2:**
```bash
# Same steps as Project 1, but in /var/www/project2
sudo mkdir -p /var/www/project2
cd /var/www/project2
# ... repeat steps above
```

---

## 🔒 **SSL CERTIFICATES (Free with Let's Encrypt)**

### **Install SSL for Both Projects:**
```bash
# Project 1
sudo certbot --nginx -d pos.tharchocafe.com

# Project 2
sudo certbot --nginx -d admin.tharchocafe.com

# Auto-renewal (already setup by certbot)
sudo certbot renew --dry-run
```

**After SSL, your sites will be:**
- https://pos.tharchocafe.com ✅
- https://admin.tharchocafe.com ✅

---

## 🎯 **DNS CONFIGURATION**

### **Add DNS Records:**

**At your domain registrar (e.g., Namecheap, GoDaddy):**

```
Type    Name    Value               TTL
A       pos     YOUR_VPS_IP         300
A       admin   YOUR_VPS_IP         300
```

**Or use CNAME:**
```
Type    Name    Value               TTL
CNAME   pos     yourdomain.com      300
CNAME   admin   yourdomain.com      300
```

---

## 💾 **RESOURCE MANAGEMENT**

### **Monitor Resources:**
```bash
# Check memory usage
free -h

# Check disk usage
df -h

# Check CPU usage
top

# Check processes
ps aux | grep php
```

### **Optimize for Multiple Projects:**

**1. PHP-FPM Pool Configuration:**

Create separate pools: `/etc/php/8.2/fpm/pool.d/project1.conf`

```ini
[project1]
user = www-data
group = www-data
listen = /var/run/php/php8.2-fpm-project1.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
```

**2. MySQL Optimization:**

Edit: `/etc/mysql/mysql.conf.d/mysqld.cnf`

```ini
[mysqld]
max_connections = 50
innodb_buffer_pool_size = 512M
query_cache_size = 32M
```

**3. Nginx Optimization:**

Edit: `/etc/nginx/nginx.conf`

```nginx
worker_processes auto;
worker_connections 1024;
keepalive_timeout 65;
gzip on;
gzip_types text/plain text/css application/json application/javascript;
```

---

## 🔄 **DEPLOYMENT WORKFLOW**

### **Using Git (Recommended):**

**Setup Git Hooks:**

Create: `/var/www/project1/deploy.sh`

```bash
#!/bin/bash
cd /var/www/project1
git pull origin main
composer install --no-dev --optimize-autoloader
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl reload php8.2-fpm
```

**Make executable:**
```bash
chmod +x /var/www/project1/deploy.sh
```

**Deploy:**
```bash
cd /var/www/project1
./deploy.sh
```

---

## 📊 **COST ESTIMATION**

### **VPS Options:**

**DigitalOcean:**
```
$6/month:   1 CPU, 1GB RAM, 25GB SSD  (Tight for 2 projects)
$12/month:  1 CPU, 2GB RAM, 50GB SSD  (Good for 2 projects)
$24/month:  2 CPU, 4GB RAM, 80GB SSD  (Comfortable for 2+ projects)
```

**Linode:**
```
$5/month:   1 CPU, 1GB RAM, 25GB SSD  (Tight)
$10/month:  1 CPU, 2GB RAM, 50GB SSD  (Good)
$20/month:  2 CPU, 4GB RAM, 80GB SSD  (Comfortable)
```

**Vultr:**
```
$6/month:   1 CPU, 1GB RAM, 25GB SSD  (Tight)
$12/month:  1 CPU, 2GB RAM, 55GB SSD  (Good)
$24/month:  2 CPU, 4GB RAM, 80GB SSD  (Comfortable)
```

**Recommendation:** $12-24/month VPS for 2 Laravel projects

---

## ⚡ **QUICK SETUP SCRIPT**

Create: `setup-multi-project.sh`

```bash
#!/bin/bash

echo "🚀 Setting up VPS for multiple Laravel projects..."

# Update system
sudo apt update && sudo apt upgrade -y

# Install Nginx
sudo apt install nginx -y

# Install PHP 8.2
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.2-fpm php8.2-cli php8.2-mysql php8.2-xml \
  php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath -y

# Install MySQL
sudo apt install mysql-server -y
sudo mysql_secure_installation

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y

# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Create project directories
sudo mkdir -p /var/www/project1
sudo mkdir -p /var/www/project2

# Set permissions
sudo chown -R $USER:www-data /var/www

echo "✅ VPS setup complete!"
echo "📋 Next steps:"
echo "1. Upload your projects to /var/www/project1 and /var/www/project2"
echo "2. Configure Nginx for each project"
echo "3. Setup databases"
echo "4. Install SSL certificates"
```

---

## 🎯 **BEST PRACTICES**

### **1. Separate Everything:**
- ✅ Separate databases
- ✅ Separate .env files
- ✅ Separate Nginx configs
- ✅ Separate PHP-FPM pools (optional)

### **2. Security:**
- ✅ Use SSL for all projects
- ✅ Different database users
- ✅ Strong passwords
- ✅ Firewall rules
- ✅ Regular updates

### **3. Monitoring:**
- ✅ Setup error logging
- ✅ Monitor disk space
- ✅ Monitor memory usage
- ✅ Setup backups

### **4. Backups:**
```bash
# Backup script
#!/bin/bash
DATE=$(date +%Y%m%d)
mysqldump -u root -p project1_db > /backups/project1_$DATE.sql
mysqldump -u root -p project2_db > /backups/project2_$DATE.sql
tar -czf /backups/project1_files_$DATE.tar.gz /var/www/project1
tar -czf /backups/project2_files_$DATE.tar.gz /var/www/project2
```

---

## 🎊 **SUMMARY**

**YES! You can host multiple Laravel projects on one VPS!**

**Recommended Setup:**
- ✅ Use subdomains (pos.domain.com, admin.domain.com)
- ✅ Separate Nginx configs
- ✅ Separate databases
- ✅ SSL for all projects
- ✅ 2GB+ RAM VPS

**Cost:** $12-24/month for comfortable hosting

**Time to Setup:** 2-4 hours for first time

---

**Ready to deploy? Follow the steps above!** 🚀
