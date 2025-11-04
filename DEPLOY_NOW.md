# 🚀 DEPLOY NOW - Quick Start

## 📋 **SERVER INFO**

```
IP: 203.161.56.115
Domain: pos.tharcho.app
```

---

## ⚡ **QUICK DEPLOY (3 STEPS)**

### **Step 1: Upload Files**
```bash
# From your Mac terminal
cd /Users/developer/Downloads/teahouse-pos
scp -r * root@203.161.56.115:/root/teahouse-pos/
```

### **Step 2: Connect to Server**
```bash
ssh root@203.161.56.115
```

### **Step 3: Run Deployment**
```bash
# On server
cd /root/teahouse-pos
chmod +x quick-deploy.sh
./quick-deploy.sh
```

**That's it!** 🎉

---

## 📝 **WHAT THE SCRIPT DOES:**

```
✅ Installs PHP 8.2
✅ Installs MySQL
✅ Installs Nginx
✅ Creates database
✅ Deploys application
✅ Configures .env
✅ Runs migrations
✅ Seeds menu items
✅ Creates admin user
✅ Configures Nginx
✅ Installs SSL certificate
✅ Sets up firewall
```

**Time:** ~30 minutes

---

## ⚙️ **DURING DEPLOYMENT:**

### **You'll be asked for:**
```
1. MySQL root password (create new)
2. Database password (create new)
3. Admin email (e.g., admin@tharcho.app)
4. Admin password (create strong password)
```

### **Write them down:**
```
MySQL Root Password: _______________
Database Password: _______________
Admin Email: _______________
Admin Password: _______________
```

---

## ✅ **AFTER DEPLOYMENT:**

### **Access Your Site:**
```
Website: https://pos.tharcho.app
Admin: https://pos.tharcho.app/admin/dashboard
```

### **Login:**
```
Email: (your admin email)
Password: (your admin password)
```

### **First Steps:**
```
1. Login to admin
2. Go to Settings
3. Configure:
   - Upload logo
   - Set tax rate
   - Set service charge
4. Create user accounts
5. Test POS
6. Train staff
7. Go live!
```

---

## 🆘 **IF SOMETHING GOES WRONG:**

### **Check Logs:**
```bash
# Application logs
tail -f /var/www/pos.tharcho.app/storage/logs/laravel.log

# Nginx logs
tail -f /var/log/nginx/error.log
```

### **Restart Services:**
```bash
systemctl restart nginx
systemctl restart php8.2-fpm
systemctl restart mysql
```

### **Re-run Deployment:**
```bash
cd /root/teahouse-pos
./quick-deploy.sh
```

---

## 📞 **NEED MANUAL DEPLOYMENT?**

See: `DEPLOYMENT_GUIDE.md`

---

## 🎯 **CHECKLIST:**

- [ ] Files uploaded to server
- [ ] SSH connected
- [ ] Deployment script run
- [ ] Website accessible
- [ ] Admin login works
- [ ] Settings configured
- [ ] Users created
- [ ] POS tested

---

## 🎉 **READY?**

```bash
# Let's go!
ssh root@203.161.56.115
```

**Good luck! 🚀**
