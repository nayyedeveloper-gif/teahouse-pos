# 🚀 DEPLOY TO EXISTING VPS

## 📋 **SCENARIO**

**Existing:** Project already running on VPS  
**New:** Tea House POS System  
**Server:** 203.161.56.115  
**New Domain:** pos.tharcho.app

---

## ✅ **PREREQUISITES CHECK**

### **Step 1: Check Server Resources**
```bash
ssh root@203.161.56.115

# Check disk space (need at least 5GB free)
df -h

# Check RAM (need at least 1GB free)
free -h

# Check existing projects
ls -la /var/www/

# Check Nginx sites
ls -la /etc/nginx/sites-available/
```

### **Minimum Requirements:**
```
✅ 5GB free disk space
✅ 1GB free RAM
✅ PHP 8.2 (will install if not present)
✅ MySQL (will use existing or install)
✅ Nginx (will use existing)
```

---

## 🎯 **DEPLOYMENT APPROACH**

### **What Will Happen:**
```
1. Keep existing project untouched ✅
2. Create new directory: /var/www/pos.tharcho.app
3. Create new database: teahouse_pos
4. Configure new Nginx site
5. Install SSL for pos.tharcho.app
6. Both projects run independently
```

### **File Structure:**
```
/var/www/
├── existing-project/          ← Untouched
│   ├── public/
│   └── ...
└── pos.tharcho.app/          ← New
    ├── public/
    ├── app/
    ├── database/
    └── ...
```

### **Nginx Configuration:**
```
/etc/nginx/sites-available/
├── existing-domain.conf       ← Untouched
└── pos.tharcho.app           ← New
```

---

## 🚀 **DEPLOYMENT STEPS**

### **Step 1: Upload Files**
```bash
# From your Mac
cd /Users/developer/Downloads/teahouse-pos
scp -r * root@203.161.56.115:/root/teahouse-pos/
```

### **Step 2: Connect to Server**
```bash
ssh root@203.161.56.115
```

### **Step 3: Check Existing Setup**
```bash
# Check PHP version
php -v

# If PHP 8.2 not installed, script will install it
# If MySQL not installed, script will install it
# Nginx should already be there

# Check current sites
ls -la /var/www/
```

### **Step 4: Run Modified Deployment**
```bash
cd /root/teahouse-pos
chmod +x quick-deploy.sh
./quick-deploy.sh
```

**Script will:**
- Detect existing software
- Install only what's missing
- Create new project directory
- Configure new site
- Keep existing project running

---

## ⚙️ **CONFIGURATION DIFFERENCES**

### **Database:**
```
Existing Project DB: (unchanged)
New POS DB: teahouse_pos

Both use same MySQL server
Separate databases
No conflicts
```

### **Web Server:**
```
Existing Site: existing-domain.com
New Site: pos.tharcho.app

Both use same Nginx
Different server blocks
Different ports (both 80/443)
Virtual hosts
```

### **PHP:**
```
If PHP 8.2 not installed:
- Will install PHP 8.2
- Existing project can still use old PHP version
- Use different PHP-FPM sockets

If PHP 8.2 already installed:
- Will use existing installation
- Both projects share PHP
```

---

## 🔒 **SECURITY CONSIDERATIONS**

### **Isolation:**
```
✅ Separate directories
✅ Separate databases
✅ Separate Nginx configs
✅ Separate SSL certificates
✅ Separate logs
```

### **Permissions:**
```
/var/www/existing-project/    ← www-data:www-data
/var/www/pos.tharcho.app/     ← www-data:www-data

No cross-access
Each project isolated
```

---

## 📊 **RESOURCE SHARING**

### **What's Shared:**
```
✅ CPU
✅ RAM
✅ Disk I/O
✅ Network bandwidth
✅ MySQL server
✅ Nginx server
✅ PHP-FPM pool (optional)
```

### **What's Separate:**
```
✅ Application files
✅ Databases
✅ Configurations
✅ Logs
✅ SSL certificates
✅ Domains
```

---

## 🆘 **TROUBLESHOOTING**

### **Issue: Port 80/443 Already in Use**
```
Solution: Normal! Nginx handles multiple sites
No action needed
```

### **Issue: Not Enough Disk Space**
```bash
# Check space
df -h

# Clean up if needed
apt autoremove
apt clean
journalctl --vacuum-time=7d

# Or upgrade server disk
```

### **Issue: Not Enough RAM**
```bash
# Check RAM
free -h

# Options:
1. Upgrade server RAM
2. Add swap space
3. Optimize existing project
```

### **Issue: PHP Version Conflict**
```
Solution: Use different PHP-FPM sockets

Existing project: /var/run/php/php7.4-fpm.sock
New POS: /var/run/php/php8.2-fpm.sock

Both can run simultaneously
```

---

## ✅ **POST-DEPLOYMENT VERIFICATION**

### **Check Both Sites:**
```bash
# Check existing site
curl -I https://existing-domain.com
# Should return 200 OK

# Check new site
curl -I https://pos.tharcho.app
# Should return 200 OK
```

### **Check Resources:**
```bash
# Check CPU usage
top

# Check RAM usage
free -h

# Check disk usage
df -h

# Check Nginx
systemctl status nginx

# Check MySQL
systemctl status mysql
```

### **Check Logs:**
```bash
# Existing project logs
tail -f /var/www/existing-project/storage/logs/laravel.log

# New POS logs
tail -f /var/www/pos.tharcho.app/storage/logs/laravel.log

# Nginx logs
tail -f /var/log/nginx/error.log
```

---

## 🎯 **BEST PRACTICES**

### **Monitoring:**
```
✅ Monitor CPU usage
✅ Monitor RAM usage
✅ Monitor disk space
✅ Monitor both sites uptime
✅ Setup alerts
```

### **Backups:**
```
✅ Backup both databases separately
✅ Backup both project files
✅ Backup Nginx configs
✅ Test restore procedures
```

### **Maintenance:**
```
✅ Update system packages regularly
✅ Update PHP regularly
✅ Update MySQL regularly
✅ Monitor security updates
```

---

## 📝 **EXAMPLE NGINX CONFIGURATION**

### **Existing Site:**
```nginx
# /etc/nginx/sites-available/existing-domain.com
server {
    listen 80;
    server_name existing-domain.com;
    root /var/www/existing-project/public;
    # ... rest of config
}
```

### **New POS Site:**
```nginx
# /etc/nginx/sites-available/pos.tharcho.app
server {
    listen 80;
    server_name pos.tharcho.app;
    root /var/www/pos.tharcho.app/public;
    # ... rest of config
}
```

**Both active simultaneously!**

---

## 🎊 **SUMMARY**

### **Can Deploy to Same VPS?**
```
✅ YES! Absolutely!
```

### **Will It Affect Existing Project?**
```
✅ NO! Completely separate
```

### **Need New Server?**
```
❌ NO! Use existing server
```

### **Cost?**
```
✅ $0 extra
```

### **Difficulty?**
```
✅ Same as new server
✅ Script handles everything
```

---

## 🚀 **READY TO DEPLOY**

```bash
# Step 1: Upload
scp -r * root@203.161.56.115:/root/teahouse-pos/

# Step 2: Connect
ssh root@203.161.56.115

# Step 3: Deploy
cd /root/teahouse-pos
chmod +x quick-deploy.sh
./quick-deploy.sh
```

**Script will:**
- Detect existing setup
- Install only what's needed
- Keep existing project safe
- Deploy new POS system
- Configure everything
- Done! ✅

---

## ✅ **FINAL ANSWER**

**လက်ရှိ VPS မှာပဲ တင်လို့ ရပါတယ်!** ✅

**အကျိုးကျေးဇူးများ:**
- ✅ ပိုက်ဆံ သက်သာတယ်
- ✅ လွယ်ကူတယ်
- ✅ လက်ရှိ project ကို မထိခိုက်ဘူး
- ✅ နှစ်ခုလုံး သီးခြား အလုပ်လုပ်တယ်

**အသစ် VPS လိုအပ်တာ:**
- ❌ မလိုပါဘူး
- ❌ ပိုက်ဆံ ကုန်တယ်
- ❌ ပိုရှုပ်ထွေးတယ်

**Recommendation: Same VPS ကို သုံးပါ!** 🎯
