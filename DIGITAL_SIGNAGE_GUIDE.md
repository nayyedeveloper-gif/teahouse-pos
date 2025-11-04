# Digital Signage System - Complete Guide

## 🎯 Overview

A fully-featured Digital Signage system for displaying menu items, promotional videos, and advertisements on TV screens.

---

## ✨ Features

### 1. **Menu Display**
- ✅ Auto-rotating categories
- ✅ Beautiful item cards with images
- ✅ Real-time price updates
- ✅ Availability status
- ✅ Myanmar language support

### 2. **Media/Ads System**
- ✅ Video support (MP4, WebM, MOV)
- ✅ Image support (JPG, PNG, GIF)
- ✅ Custom duration per media
- ✅ Auto-rotation between menu and media
- ✅ Full-screen display

### 3. **Customization**
- ✅ Enable/disable signage
- ✅ Adjustable rotation speed (5-60 seconds)
- ✅ Auto-refresh interval (1-60 minutes)
- ✅ Dark/Light theme
- ✅ Show/hide prices
- ✅ Show/hide descriptions
- ✅ Show/hide availability
- ✅ Show/hide media/ads

### 4. **Management**
- ✅ Easy media upload
- ✅ Enable/disable individual media
- ✅ Sort order management
- ✅ Myanmar language support
- ✅ Grid view with previews

---

## 🚀 Quick Start

### Step 1: Access Settings
```
Admin → Profile → System Settings → Digital Signage Tab
```

### Step 2: Enable Digital Signage
```
☑ Digital Signage ဖွင့်ရန်
```

### Step 3: Configure Display
```
- Rotation Speed: 10 seconds (recommended)
- Auto Refresh: 5 minutes (recommended)
- Theme: Dark (recommended for TV)
```

### Step 4: Upload Media (Optional)
```
Admin → Profile → 📺 Signage Media
→ Click "Add Media"
→ Upload video or image
→ Set duration
→ Save
```

### Step 5: Open Display
```
URL: http://your-domain.com/display/signage
→ Press F11 for fullscreen
→ Leave running on TV
```

---

## 📊 Settings Reference

### **Signage Control**
| Setting | Description | Default |
|---------|-------------|---------|
| Digital Signage ဖွင့်ရန် | Enable/disable entire system | ON |
| Promotional Message | Scrolling text at top | "Welcome!" |

### **Display Settings**
| Setting | Description | Range | Default |
|---------|-------------|-------|---------|
| Rotation Speed | Category change interval | 5-60 sec | 10 sec |
| Auto Refresh | Price update interval | 1-60 min | 5 min |
| Theme | Display color scheme | Dark/Light | Dark |

### **Content Settings**
| Setting | Description | Default |
|---------|-------------|---------|
| စျေးနှုန်းများ ပြသရန် | Show item prices | ON |
| အကြောင်းအရာ ပြသရန် | Show descriptions | ON |
| ရရှိနိုင်မှု Status ပြသရန် | Show availability | ON |
| Videos/Ads ပြသရန် | Show media between items | ON |

---

## 🎬 Media Management

### **Supported Formats**

**Videos:**
- MP4 (recommended)
- WebM
- MOV
- Max size: 50MB

**Images:**
- JPG/JPEG
- PNG
- GIF
- Max size: 50MB

### **Upload Process**

1. **Go to Media Management**
   ```
   Admin → Profile → 📺 Signage Media
   ```

2. **Click "Add Media"**

3. **Fill Form:**
   - Title (English)
   - Title (Myanmar) - optional
   - Media Type (Video/Image)
   - Upload File
   - Duration (seconds)
   - Description - optional
   - ☑ Active

4. **Click "Save"**

### **Media Display Logic**

```
Menu Items (10 sec) → Menu Items (10 sec) → Media (duration) → Menu Items...
```

- Media shows randomly between menu rotations
- Probability: ~30% chance per rotation
- Duration: As set in media settings
- Full-screen display
- Auto-play for videos

---

## 🎨 Display Modes

### **Menu Mode**
```
┌─────────────────────────────────────────┐
│ 🏪 Logo  Restaurant Name    🕐 2:30 PM │
│ 🎉 Promotional Message (scrolling) 🎉  │
├─────────────────────────────────────────┤
│ [Drinks] [Food] [Desserts] [Snacks]    │
├─────────────────────────────────────────┤
│ ┌────┐ ┌────┐ ┌────┐ ┌────┐           │
│ │🖼️  │ │🖼️  │ │🖼️  │ │🖼️  │           │
│ │Tea │ │Cof │ │Jui │ │Smo │           │
│ │3000│ │4000│ │2500│ │3500│           │
│ └────┘ └────┘ └────┘ └────┘           │
├─────────────────────────────────────────┤
│ 🟢 Live Updates  |  © 2025 Restaurant  │
└─────────────────────────────────────────┘
```

### **Media Mode**
```
┌─────────────────────────────────────────┐
│                                         │
│                                         │
│          🎥 FULL SCREEN VIDEO          │
│              or                         │
│          🖼️ FULL SCREEN IMAGE          │
│                                         │
│                                         │
└─────────────────────────────────────────┘
```

---

## 🔧 Technical Details

### **Database Tables**

**signage_media**
```sql
- id
- title (English)
- title_mm (Myanmar)
- type (video/image)
- file_path
- duration (seconds)
- sort_order
- is_active
- description
- timestamps
```

**settings**
```
- signage_enabled
- promotional_message
- signage_rotation_speed
- signage_show_prices
- signage_show_descriptions
- signage_show_availability
- signage_theme
- signage_auto_refresh
- signage_show_media
```

### **File Storage**
```
storage/app/public/signage-media/
├─ video1.mp4
├─ promo1.jpg
├─ ad1.png
└─ ...
```

### **Routes**
```php
// Display
GET /display/signage

// Management
GET /admin/signage-media
```

### **Components**
```
MenuBoard.php - Main display component
SignageMediaManagement.php - Media CRUD
```

---

## 💡 Best Practices

### **For TV Display**

1. **Hardware:**
   - Use 32"+ TV or monitor
   - HDMI connection
   - Stable internet
   - Power backup (UPS)

2. **Browser:**
   - Chrome (recommended)
   - Firefox
   - Edge
   - Enable auto-start on boot

3. **Settings:**
   - Fullscreen (F11)
   - Disable screen saver
   - Disable sleep mode
   - Set homepage to display URL

### **For Content**

1. **Videos:**
   - Keep under 30 seconds
   - High quality (1080p)
   - Clear audio (muted on display)
   - Professional editing

2. **Images:**
   - High resolution (1920x1080)
   - Clear text
   - Good contrast
   - Professional design

3. **Messages:**
   - Short and catchy
   - Use emojis
   - Myanmar + English
   - Update regularly

### **For Performance**

1. **Optimize Media:**
   - Compress videos
   - Optimize images
   - Keep file sizes reasonable
   - Use web-friendly formats

2. **Monitor:**
   - Check display daily
   - Update content weekly
   - Review analytics monthly
   - Maintain hardware

---

## 🎯 Use Cases

### **1. Restaurant Menu**
```
- Display all menu items
- Show current prices
- Highlight specials
- Seasonal promotions
```

### **2. Promotional Campaigns**
```
- New product launches
- Limited time offers
- Combo deals
- Happy hour specials
```

### **3. Brand Building**
```
- Company videos
- Behind the scenes
- Customer testimonials
- Social media handles
```

### **4. Information Display**
```
- Opening hours
- WiFi password
- Special announcements
- Event schedules
```

---

## 🔍 Troubleshooting

### **Display Not Showing**

**Check:**
1. Is signage enabled in settings?
2. Is browser connected to internet?
3. Is URL correct?
4. Try refresh (Ctrl+R)

### **Media Not Playing**

**Check:**
1. Is "Videos/Ads ပြသရန်" enabled?
2. Is media marked as "Active"?
3. Is file format supported?
4. Is file size under 50MB?

### **Prices Not Updating**

**Check:**
1. Auto-refresh setting
2. Internet connection
3. Browser cache (Ctrl+Shift+R)
4. Database connection

### **Rotation Too Fast/Slow**

**Fix:**
1. Go to Settings → Digital Signage
2. Adjust "Rotation Speed"
3. Save settings
4. Refresh display

---

## 📈 Future Enhancements

### **Planned Features**
- [ ] Weather widget
- [ ] Social media feed
- [ ] QR code for ordering
- [ ] Multi-screen support
- [ ] Schedule-based content
- [ ] Analytics dashboard
- [ ] Remote control
- [ ] Voice announcements

### **Advanced Options**
- [ ] Video playlists
- [ ] Transition effects
- [ ] Custom layouts
- [ ] Interactive touch
- [ ] Mobile app control
- [ ] Cloud sync
- [ ] AI recommendations

---

## 📞 Support

### **Quick Links**
- Settings: `/admin/settings` → Digital Signage Tab
- Media Management: `/admin/signage-media`
- Display URL: `/display/signage`

### **Common Tasks**

**Add New Media:**
```
Profile → 📺 Signage Media → Add Media
```

**Change Rotation Speed:**
```
Settings → Digital Signage → Rotation Speed
```

**Update Promotional Message:**
```
Settings → Digital Signage → Promotional Message
```

**Enable/Disable Display:**
```
Settings → Digital Signage → Toggle Switch
```

---

## ✅ Checklist

### **Initial Setup**
- [ ] Enable Digital Signage
- [ ] Set rotation speed
- [ ] Set auto-refresh
- [ ] Choose theme
- [ ] Add promotional message
- [ ] Upload first media
- [ ] Test on TV
- [ ] Train staff

### **Daily Operations**
- [ ] Check display is running
- [ ] Verify prices are current
- [ ] Monitor for errors
- [ ] Update promotions as needed

### **Weekly Maintenance**
- [ ] Add new media
- [ ] Remove outdated content
- [ ] Update promotional message
- [ ] Check media quality

### **Monthly Review**
- [ ] Review all settings
- [ ] Update seasonal content
- [ ] Clean up old media
- [ ] Optimize performance

---

## 🎉 Conclusion

Your Digital Signage system is now fully functional and production-ready!

**Key Benefits:**
✅ Professional appearance
✅ Easy to manage
✅ Real-time updates
✅ Myanmar language support
✅ Cost-effective
✅ Engaging customers
✅ Increase sales

**Next Steps:**
1. Upload your first media
2. Customize settings
3. Open display on TV
4. Start attracting customers!

---

**© 2025 Teahouse POS - Digital Signage System**
