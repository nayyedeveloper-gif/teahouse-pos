# သာချို ကဖေးနှင့်စားဖွယ်စုံ - Installation Guide
# သာချိုကော်ဖီဆိုင် POS - တပ်ဆင်ခြင်း လမ်းညွှန်

## System Requirements / လိုအပ်ချက်များ

- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer
- Node.js 18+ and NPM
- Network Receipt Printer (ESC/POS compatible)

## Installation Steps / တပ်ဆင်ခြင်း အဆင့်များ

### 1. Install Dependencies / Dependencies များ ထည့်သွင်းခြင်း

```bash
cd /Users/developer/Downloads/teahouse-pos

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 2. Environment Configuration / ပတ်ဝန်းကျင် ပြင်ဆင်ခြင်း

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup / Database ပြင်ဆင်ခြင်း

Edit `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teahouse_pos
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database:

```bash
mysql -u root -p
CREATE DATABASE teahouse_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

### 4. Printer Configuration / Printer ပြင်ဆင်ခြင်း

Edit `.env` file and configure your network printers:

```env
# Kitchen Printer
KITCHEN_PRINTER_IP=192.168.1.100
KITCHEN_PRINTER_PORT=9100

# Bar Printer
BAR_PRINTER_IP=192.168.1.101
BAR_PRINTER_PORT=9100

# Receipt Printer
RECEIPT_PRINTER_IP=192.168.1.102
RECEIPT_PRINTER_PORT=9100
```

**Note:** After installation, you need to activate printers in Admin Panel > Printers

### 5. Business Information / လုပ်ငန်း အချက်အလက်များ

Edit `.env` file:

```env
BUSINESS_NAME="Thar Cho Cafe"
BUSINESS_NAME_MM="သာချိုကော်ဖီဆိုင်"
BUSINESS_ADDRESS="Yangon, Myanmar"
BUSINESS_ADDRESS_MM="ရန်ကုန်မြို့၊ မြန်မာနိုင်ငံ"
BUSINESS_PHONE="+95 9 123 456 789"
```

### 6. Build Assets / Assets များ တည်ဆောက်ခြင်း

```bash
# For development
npm run dev

# For production
npm run build
```

### 7. Storage Link / Storage လင့်ခ်

```bash
php artisan storage:link
```

### 8. Start Development Server / Development Server စတင်ခြင်း

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Default Login Credentials / မူလ အကောင့်များ

### Admin
- Email: admin@tharchocafe.com
- Password: password

### Cashier
- Email: cashier@tharchocafe.com
- Password: password

### Waiter
- Email: waiter@tharchocafe.com
- Password: password

## Production Deployment / Production တွင် Deploy လုပ်ခြင်း

### 1. Optimize Application

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 2. Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 3. Configure Web Server

#### Apache

Create `.htaccess` in public directory (already included)

#### Nginx

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/teahouse-pos/public;

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

### 4. Setup Queue Worker (Optional)

```bash
# Install supervisor
sudo apt-get install supervisor

# Create supervisor configuration
sudo nano /etc/supervisor/conf.d/teahouse-pos-worker.conf
```

Add:

```ini
[program:teahouse-pos-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/teahouse-pos/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/teahouse-pos/storage/logs/worker.log
```

Start supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start teahouse-pos-worker:*
```

## Network Printer Setup / Network Printer တပ်ဆင်ခြင်း

### ESC/POS Printer Configuration

1. Connect printer to network
2. Set static IP address on printer
3. Test connection:

```bash
ping 192.168.1.100
```

4. Test print (Linux/Mac):

```bash
echo "Test Print" | nc 192.168.1.100 9100
```

5. Configure in Admin Panel:
   - Go to Admin > Printers
   - Enable printer
   - Set IP address and port
   - Assign categories to Kitchen/Bar printers

## PWA Installation / PWA တပ်ဆင်ခြင်း

### On Mobile/Tablet

1. Open website in Chrome/Safari
2. Tap menu (⋮ or share icon)
3. Select "Add to Home Screen"
4. Tap "Add"

### On Desktop

1. Open website in Chrome
2. Click install icon in address bar
3. Click "Install"

## Troubleshooting / ပြဿနာ ဖြေရှင်းခြင်း

### Database Connection Error

```bash
# Check MySQL service
sudo systemctl status mysql

# Check credentials in .env
php artisan config:clear
```

### Permission Errors

```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Printer Not Working

1. Check network connection
2. Verify IP address and port
3. Check printer is ESC/POS compatible
4. Enable printer in Admin Panel
5. Check firewall settings

### Myanmar Font Not Displaying

1. Clear browser cache
2. Check internet connection (fonts loaded from CDN)
3. Install Pyidaungsu or Padauk font on system

## Backup / Backup ယူခြင်း

### Database Backup

```bash
mysqldump -u root -p teahouse_pos > backup_$(date +%Y%m%d).sql
```

### Full Backup

```bash
tar -czf teahouse-pos-backup-$(date +%Y%m%d).tar.gz /path/to/teahouse-pos
```

## Support / အကူအညီ

For technical support, contact:
- Email: support@tharchocafe.com
- Phone: +95 9 123 456 789

## License

This software is proprietary and licensed to Thar Cho Cafe.
