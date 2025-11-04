# 🔧 PRODUCTION .env CONFIGURATION

## 📋 **FOR: pos.tharcho.app**

**Server IP:** 203.161.56.115

---

## ⚙️ **PRODUCTION .env FILE**

Copy this configuration to your server's `.env` file:

```env
# Application
APP_NAME="သာချို ကဖေးနှင့်စားဖွယ်စုံ"
APP_ENV=production
APP_KEY=base64:GENERATE_THIS_ON_SERVER
APP_DEBUG=false
APP_TIMEZONE=Asia/Yangon
APP_URL=https://pos.tharcho.app
APP_LOCALE=my
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

# Logging
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teahouse_pos
DB_USERNAME=teahouse_user
DB_PASSWORD=YOUR_SECURE_PASSWORD_HERE

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

# Cache & Queue
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database
CACHE_PREFIX=

# Redis (Optional)
MEMCACHED_HOST=127.0.0.1
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail (Optional - for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tharcho.app"
MAIL_FROM_NAME="${APP_NAME}"

# AWS (Not needed for now)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

# Vite
VITE_APP_NAME="${APP_NAME}"

# Receipt Printer Configuration (Update with your printer IPs)
KITCHEN_PRINTER_IP=192.168.1.100
KITCHEN_PRINTER_PORT=9100
BAR_PRINTER_IP=192.168.1.101
BAR_PRINTER_PORT=9100
RECEIPT_PRINTER_IP=192.168.1.102
RECEIPT_PRINTER_PORT=9100

# Business Information
BUSINESS_NAME="Thar Cho Cafe"
BUSINESS_NAME_MM="သာချိုကော်ဖီဆိုင်"
BUSINESS_ADDRESS="Yangon, Myanmar"
BUSINESS_ADDRESS_MM="ရန်ကုန်မြို့၊ မြန်မာနိုင်ငံ"
BUSINESS_PHONE="+95 9 123 456 789"
BUSINESS_TAX_ID=""

# PWA Configuration
PWA_NAME="Thar Cho POS"
PWA_SHORT_NAME="TharCho"
PWA_THEME_COLOR="#10b981"
PWA_BACKGROUND_COLOR="#ffffff"
```

---

## 🚀 **DEPLOYMENT STEPS**

### **1. Connect to Server:**
```bash
ssh root@203.161.56.115
```

### **2. Follow Quick Deploy:**
```bash
# Upload and run quick-deploy.sh
# OR follow DEPLOYMENT_GUIDE.md
```

### **3. Configure .env on Server:**
```bash
cd /var/www/pos.tharcho.app
nano .env
```

### **4. Important Changes:**
```env
APP_ENV=production          # NOT local
APP_DEBUG=false             # NOT true
APP_URL=https://pos.tharcho.app  # NOT localhost
DB_PASSWORD=YOUR_PASSWORD   # Set during deployment
LOG_LEVEL=error             # NOT debug
```

### **5. Generate APP_KEY:**
```bash
php artisan key:generate
```

---

## ⚠️ **CRITICAL SETTINGS**

### **Must Change:**
```
✅ APP_ENV=production
✅ APP_DEBUG=false
✅ APP_URL=https://pos.tharcho.app
✅ DB_PASSWORD=strong_password
✅ LOG_LEVEL=error
```

### **Optional (Can Configure Later):**
```
⏳ MAIL_* (for email notifications)
⏳ PRINTER_* (for receipt printing)
⏳ BUSINESS_* (can update in admin panel)
```

---

## 📝 **NOTES**

### **Local vs Production:**
```
Local (.env):
- APP_ENV=local
- APP_DEBUG=true
- APP_URL=http://localhost
- DB_PASSWORD= (empty or simple)

Production (.env on server):
- APP_ENV=production
- APP_DEBUG=false
- APP_URL=https://pos.tharcho.app
- DB_PASSWORD=strong_secure_password
```

### **Security:**
```
✅ Never commit .env to Git
✅ Use strong database password
✅ Keep APP_DEBUG=false in production
✅ Use HTTPS (SSL certificate)
✅ Restrict file permissions (chmod 600 .env)
```

---

## 🎯 **QUICK REFERENCE**

### **Server Info:**
```
IP: 203.161.56.115
Domain: pos.tharcho.app
App Path: /var/www/pos.tharcho.app
Database: teahouse_pos
DB User: teahouse_user
```

### **After Deployment:**
```
Website: https://pos.tharcho.app
Admin: https://pos.tharcho.app/admin/dashboard
```

---

## ✅ **READY TO DEPLOY!**

**Steps:**
1. SSH to server: `ssh root@203.161.56.115`
2. Run deployment script
3. Configure .env (use this file as reference)
4. Generate APP_KEY
5. Run migrations
6. Test and launch!

**Good luck! 🚀**
