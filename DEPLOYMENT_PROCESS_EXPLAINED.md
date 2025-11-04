# 📖 DEPLOYMENT PROCESS - STEP BY STEP

## ❓ **YOUR QUESTION:**

**"/var/www/pos.tharcho.app က ဘယ်လို new project လုပ်ရမလဲ?"**

---

## ✅ **ANSWER:**

**Script က အလိုအလျောက် လုပ်ပေးပါမယ်!**

သင် manually `mkdir` လုပ်စရာ **မလိုပါဘူး**။

---

## 🎯 **WHAT YOU DO:**

### **Step 1: Upload Files to Server**
```bash
# Your Mac terminal
cd /Users/developer/Downloads/teahouse-pos
scp -r * root@203.161.56.115:/root/teahouse-pos/
```

**Files go to:** `/root/teahouse-pos/` (temporary location)

### **Step 2: Connect to Server**
```bash
ssh root@203.161.56.115
```

### **Step 3: Run Deployment Script**
```bash
cd /root/teahouse-pos
chmod +x quick-deploy.sh
./quick-deploy.sh
```

**That's all you do!** ✅

---

## 🤖 **WHAT SCRIPT DOES AUTOMATICALLY:**

### **Line 84 in quick-deploy.sh:**
```bash
mkdir -p $APP_DIR
```

Where `$APP_DIR = /var/www/pos.tharcho.app`

### **Full Automatic Process:**

```bash
# 1. Create directory
mkdir -p /var/www/pos.tharcho.app

# 2. Navigate to it
cd /var/www/pos.tharcho.app

# 3. Set permissions
chown -R www-data:www-data /var/www/pos.tharcho.app
chmod -R 755 /var/www/pos.tharcho.app

# 4. Copy files from /root/teahouse-pos/ to /var/www/pos.tharcho.app/
# (Script prompts you to upload files)

# 5. Install PHP dependencies
composer install --optimize-autoloader --no-dev

# 6. Install Node dependencies
npm install

# 7. Build assets
npm run build

# 8. Configure .env
cp .env.example .env
# (Edit database credentials)

# 9. Generate app key
php artisan key:generate

# 10. Run migrations
php artisan migrate --force

# 11. Seed database
php artisan db:seed --class=MenuItemsSeeder --force

# 12. Create admin user
# (Script prompts for email/password)

# 13. Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 14. Configure Nginx
# Creates /etc/nginx/sites-available/pos.tharcho.app

# 15. Enable site
ln -s /etc/nginx/sites-available/pos.tharcho.app /etc/nginx/sites-enabled/

# 16. Install SSL
certbot --nginx -d pos.tharcho.app

# 17. Setup firewall
ufw allow 'Nginx Full'

# 18. Setup cron
# Adds Laravel scheduler

# DONE! ✅
```

---

## 📊 **DIRECTORY STRUCTURE:**

### **Before Deployment:**
```
/root/
└── teahouse-pos/          ← Your uploaded files (temporary)
    ├── app/
    ├── database/
    ├── public/
    ├── quick-deploy.sh
    └── ...

/var/www/
└── (empty or has other projects)
```

### **After Deployment:**
```
/root/
└── teahouse-pos/          ← Still there (can delete later)

/var/www/
├── existing-project/      ← Your old project (untouched)
└── pos.tharcho.app/      ← NEW! Created by script
    ├── app/
    ├── database/
    ├── public/
    ├── vendor/            ← Installed by composer
    ├── node_modules/      ← Installed by npm
    ├── .env               ← Configured by script
    └── ...
```

---

## 🎯 **KEY POINTS:**

### **1. You DON'T manually create directory:**
```bash
# ❌ DON'T DO THIS:
ssh root@203.161.56.115
mkdir /var/www/pos.tharcho.app
cd /var/www/pos.tharcho.app
# ...manual setup...

# ✅ DO THIS INSTEAD:
ssh root@203.161.56.115
cd /root/teahouse-pos
./quick-deploy.sh
# Script does everything!
```

### **2. Script creates directory automatically:**
```bash
# Line 84 in quick-deploy.sh:
mkdir -p $APP_DIR

# Where APP_DIR="/var/www/pos.tharcho.app"
```

### **3. Script moves files automatically:**
```bash
# Script prompts:
"Please upload your application files to this directory"

# You can:
# Option A: Upload via SCP (already done in Step 1)
# Option B: Git clone (if using Git)
# Option C: Copy from /root/teahouse-pos/
```

---

## 🔄 **COMPLETE FLOW:**

```
┌─────────────────────────────────────┐
│ 1. Upload files to /root/          │
│    scp -r * root@IP:/root/pos/     │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ 2. SSH to server                    │
│    ssh root@203.161.56.115          │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ 3. Run deployment script            │
│    cd /root/teahouse-pos            │
│    ./quick-deploy.sh                │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ 4. Script automatically:            │
│    ✅ Creates /var/www/pos.tharcho  │
│    ✅ Copies files                  │
│    ✅ Installs dependencies         │
│    ✅ Configures everything         │
│    ✅ Sets up database              │
│    ✅ Configures Nginx              │
│    ✅ Installs SSL                  │
│    ✅ Done!                         │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│ 5. Website live!                    │
│    https://pos.tharcho.app          │
└─────────────────────────────────────┘
```

---

## 💡 **WHY USE SCRIPT?**

### **Manual Method (Hard):**
```bash
# Would need to do:
mkdir /var/www/pos.tharcho.app
cd /var/www/pos.tharcho.app
# Copy files
# Install PHP
# Install MySQL
# Install Nginx
# Install Composer
# Install Node
# composer install
# npm install
# npm run build
# Configure .env
# Create database
# Run migrations
# Configure Nginx
# Install SSL
# Setup firewall
# Setup cron
# ... 50+ more steps!

Time: 2-3 hours
Errors: Many possible
Difficulty: High
```

### **Script Method (Easy):**
```bash
# Just do:
./quick-deploy.sh

Time: 30 minutes
Errors: Script handles them
Difficulty: Easy
```

---

## 📝 **SUMMARY:**

### **Question:** `/var/www/pos.tharcho.app` ဘယ်လို လုပ်ရမလဲ?

### **Answer:**
```
❌ Manual: mkdir /var/www/pos.tharcho.app
✅ Automatic: ./quick-deploy.sh

Script က အလိုအလျောက် လုပ်ပေးပါမယ်!
```

### **You Just:**
```
1. Upload files
2. SSH to server
3. Run script
4. Answer prompts (passwords, email)
5. Done!
```

### **Script Does:**
```
✅ Creates directory
✅ Copies files
✅ Installs everything
✅ Configures everything
✅ Sets up database
✅ Configures web server
✅ Installs SSL
✅ Everything!
```

---

## 🎊 **FINAL ANSWER:**

**သင် လုပ်ရမှာ:**
```bash
scp -r * root@203.161.56.115:/root/teahouse-pos/
ssh root@203.161.56.115
cd /root/teahouse-pos
./quick-deploy.sh
```

**Script က လုပ်ပေးမှာ:**
```
✅ mkdir -p /var/www/pos.tharcho.app
✅ cd /var/www/pos.tharcho.app
✅ Copy files
✅ Install dependencies
✅ Configure everything
✅ Setup database
✅ Configure Nginx
✅ Install SSL
✅ Everything else!
```

**Time:** 30 minutes  
**Difficulty:** Easy  
**Manual work:** Minimal

---

**Just run the script! It does everything! 🚀**
