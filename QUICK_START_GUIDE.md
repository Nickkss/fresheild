# Freshield.com - Quick Start Guide

## 🚀 How to Use the New PHP Structure

### Running the Website

#### Option 1: Using PHP Built-in Server
```bash
cd d:\freshield.com
php -S localhost:8000
```
Then visit:
- Korean Homepage: http://localhost:8000/index.php
- English Homepage: http://localhost:8000/en_index.php

#### Option 2: Using XAMPP/WAMP/MAMP
1. Copy the `freshield.com` folder to your web server's document root
2. Access via: http://localhost/freshield.com/index.php

---

## 📁 Project Structure

```
freshield.com/
├── index.php              ← Korean homepage (START HERE)
├── en_index.php           ← English homepage
└── public/
    ├── assets/            ← All CSS, JS, Images
    ├── includes/          ← Header, Footer, Config
    └── pages/             ← All page templates
```

---

## 🔗 URL Mapping

### Homepage URLs
- **Korean:** `/index.php`
- **English:** `/en_index.php`

### Product Pages
- **Korean:** `/public/pages/product_[name].php`
- **English:** `/public/pages/product_[name]_en.php`

Example products:
- Outdoor: `product_outdoor1.php`
- Advance: `product_advance.php`
- Elite: `product_elite.php`
- Genisys: `product_genisys.php`

### Support Pages
- FAQ (Korean): `/public/pages/faq.php`
- FAQ (English): `/public/pages/faq_en.php`
- Manual (Korean): `/public/pages/manual.php`
- Manual (English): `/public/pages/manual_en.php`

### Other Pages
- Brand Story: `/public/pages/brandstory.php`
- Business/B2B: `/public/pages/business.php`
- Tips: `/public/pages/tip.php`
- Sitemap: `/public/pages/sitemap.php`

---

## 🛠 Creating a New Page

### Step 1: Create the PHP page template
```php
// File: public/pages/my_new_page.php
<div class="content">
    <h1>My New Page</h1>
    <p>Your content here...</p>
</div>
```

### Step 2: Create the loader file
```php
// File: my_new_page.php (in root)
<?php
$lang = 'ko';  // or 'en'
$is_english = false;  // or true

include __DIR__.'/public/includes/header.php';
include __DIR__.'/public/pages/my_new_page.php';
include __DIR__.'/public/includes/footer.php';
?>
```

### Step 3: Link to it from menu
Edit `public/includes/header.php` and add your link to the menu.

---

## 🎨 Modifying Design

### To change the header:
Edit: `public/includes/header.php`

### To change the footer:
Edit: `public/includes/footer.php`

### To change CSS:
Edit files in: `public/assets/css/`

### To change JavaScript:
Edit files in: `public/assets/js/`

### To change images:
Replace files in: `public/assets/images/`

---

## 🌐 Language Switching

The header automatically shows Korean or English menu based on:
```php
$is_english = true;   // Shows English menu
$is_english = false;  // Shows Korean menu
```

Set this variable before including the header.

---

## ⚙️ Configuration

Edit `public/includes/config.php` to:
- Set base paths
- Configure default language
- Add database credentials (Phase 2)

---

## 🐛 Troubleshooting

### Images not loading?
Check that paths start with `/public/assets/images/`

### CSS not working?
Check that paths start with `/public/assets/css/`

### JavaScript errors?
Check browser console and verify paths start with `/public/assets/js/`

### Page not found?
Verify the include paths use `__DIR__` correctly:
```php
include __DIR__.'/public/includes/header.php';
```

---

## 📋 Common Tasks

### Add a new product:
1. Create `public/pages/product_newproduct.php`
2. Copy structure from existing product page
3. Update images and text
4. Add link in header menu

### Update navigation menu:
Edit `public/includes/header.php` around line 150

### Change footer links:
Edit `public/includes/footer.php`

### Add new CSS:
1. Place file in `public/assets/css/`
2. Add `<link>` tag in `header.php`

### Add new JavaScript:
1. Place file in `public/assets/js/`
2. Add `<script>` tag in `header.php` or `footer.php`

---

## ✅ Testing Checklist

Before deploying:
- [ ] Test Korean homepage
- [ ] Test English homepage
- [ ] Test all product pages
- [ ] Test FAQ pages
- [ ] Test manual/downloads pages
- [ ] Verify all images load
- [ ] Verify all CSS loads
- [ ] Verify all JavaScript works
- [ ] Test menu navigation
- [ ] Test language switching
- [ ] Test footer links
- [ ] Test on mobile
- [ ] Test on different browsers

---

## 🚦 Next Steps (Phase 2)

Ready for:
1. Database integration
2. Admin panel development
3. Dynamic content management
4. User authentication
5. Product CRUD operations
6. FAQ management system

---

## 📞 Need Help?

Refer to:
- Full documentation: `PHASE1_COMPLETION_REPORT.md`
- Original HTML files: Still in original locations for reference

---

**Version:** Phase 1 Complete
**Last Updated:** November 15, 2025
