# သာချို ကဖေးနှင့်စားဖွယ်စုံ System

## အကြောင်းအရာ

သာချို ကဖေးနှင့်စားဖွယ်စုံ System သည် လက်ဖက်ရည်ဆိုင်နှင့် ကော်ဖီဆိုင်များအတွက် ရိုးရှင်းပြီး ခေတ်မီသော Point of Sale စနစ်ဖြစ်ပါသည်။

## နည်းပညာများ

- **Backend**: Laravel 12.x
- **Frontend**: Livewire 3.x, TailwindCSS, Alpine.js
- **Database**: MySQL 8.0+
- **PWA**: Progressive Web App Support
- **Icons**: SVG Icons (Heroicons)
- **Printing**: Network Receipt Printer Support
- **Language**: Myanmar (Burmese) Language Support

## Features

### 1. Waiter Role (စားပွဲထိုး)
- အော်ဒါယူခြင်း၊ ပြင်ဆင်ခြင်း၊ ဖျက်ခြင်း
- စားပွဲများကို စီမံခန့်ခွဲခြင်း
- လက်ရှိ အော်ဒါများကို update လုပ်ခြင်း
- Parcel အော်ဒါများ စီမံခန့်ခွဲခြင်း
- Kitchen/Bar သို့ အော်ဒါ အလိုအလျောက်ပေးပို့ခြင်း

### 2. Kitchen/Bar Role (မီးဖိုချောင်/ဘား)
- Receipt printer မှတစ်ဆင့် အော်ဒါများလက်ရှိခြင်း
- Category အလိုက် အော်ဒါများ ခွဲခြားခြင်း
- Terminal printer သာ အသုံးပြုခြင်း

### 3. Cashier Role (ငွေကိုင်)
- အော်ဒါများကို ပေါင်းစပ်ပြီး ငွေတောင်းခံခြင်း
- Receipt ထုတ်ပေးခြင်း
- Tax, Discount, Service Charge စီမံခန့်ခွဲခြင်း
- FOC items စီမံခန့်ခွဲခြင်း

### 4. Admin Role (စီမံခန့်ခွဲသူ)
- Dashboard နှင့် Reports
- Menu items စီမံခန့်ခွဲခြင်း
- Users နှင့် Roles စီမံခန့်ခွဲခြင်း
- Printer configuration
- QR Menu စီမံခန့်ခွဲခြင်း

### 5. QR Menu
- Customer များ QR Code scan ပြုလုပ်၍ Menu ကြည့်ရှုနိုင်ခြင်း

## Installation

### Requirements
- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js 18+ and NPM

### Setup Steps

```bash
# Clone the repository
cd /Users/developer/Downloads/teahouse-pos

# Install PHP dependencies
composer install

# Install NPM dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=teahouse_pos
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations and seeders
php artisan migrate --seed

# Build assets
npm run build

# Start development server
php artisan serve
```

### Default Login Credentials

**Admin**
- Email: admin@tharchocafe.com
- Password: password

**Cashier**
- Email: cashier@tharchocafe.com
- Password: password

**Waiter**
- Email: waiter@tharchocafe.com
- Password: password

## Network Printer Configuration

### ESC/POS Printer Setup
1. Admin panel မှ Settings > Printers သို့သွားပါ
2. Kitchen Printer နှင့် Bar Printer များ configure လုပ်ပါ
3. IP Address နှင့် Port ထည့်သွင်းပါ
4. Category များကို printer တစ်ခုချင်းစီသို့ assign လုပ်ပါ

## PWA Installation

### Mobile/Tablet
1. Browser (Chrome/Safari) ဖြင့် website ကို ဖွင့်ပါ
2. "Add to Home Screen" ကို နှိပ်ပါ
3. App icon သည် home screen တွင် ပေါ်လာမည်

## License

This project is proprietary software for Thar Cho Cafe.

## Support

For support, contact: support@tharchocafe.com
