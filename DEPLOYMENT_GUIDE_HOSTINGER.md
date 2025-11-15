# Freshield.com - Hostinger Deployment Guide

## Overview
This guide provides step-by-step instructions for deploying the Freshield website to Hostinger hosting.

**Estimated Time:** 30-45 minutes
**Difficulty:** Intermediate
**Prerequisites:** Hostinger hosting account with PHP & MySQL support

---

## Table of Contents
1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Step 1: Prepare Files](#step-1-prepare-files)
3. [Step 2: Upload Files to Hostinger](#step-2-upload-files-to-hostinger)
4. [Step 3: Create MySQL Database](#step-3-create-mysql-database)
5. [Step 4: Import Database Schema](#step-4-import-database-schema)
6. [Step 5: Configure Application](#step-5-configure-application)
7. [Step 6: Set File Permissions](#step-6-set-file-permissions)
8. [Step 7: SSL Certificate Setup](#step-7-ssl-certificate-setup)
9. [Step 8: Domain DNS Configuration](#step-8-domain-dns-configuration)
10. [Step 9: Create Admin User](#step-9-create-admin-user)
11. [Step 10: Final Testing](#step-10-final-testing)
12. [Post-Deployment](#post-deployment)
13. [Troubleshooting](#troubleshooting)

---

## Pre-Deployment Checklist

Before starting, ensure you have:

- ✅ Active Hostinger hosting account
- ✅ Domain name (freshield.com)
- ✅ FTP/File Manager access credentials
- ✅ All website files ready
- ✅ Database schema files
- ✅ Admin login credentials prepared
- ✅ SMTP email credentials (if using custom email)

---

## Step 1: Prepare Files

### 1.1 Create Deployment Package

On your local machine, prepare the following files for upload:

```
freshield_deploy/
├── public/
│   ├── assets/
│   │   ├── css/ (including dist/ with minified files)
│   │   ├── js/ (including dist/ with minified files)
│   │   └── images/
│   ├── includes/
│   │   ├── config.php (copy from config.sample.php)
│   │   ├── db.php
│   │   ├── header_optimized.php
│   │   ├── footer.php
│   │   └── mailer.php
│   └── pages/
├── admin/
│   ├── includes/
│   ├── images/
│   ├── lang/
│   └── [all admin PHP files]
├── database/
│   ├── schema_freshield.sql
│   └── schema_phase4_additions.sql
├── uploads/
│   └── manuals/ (empty folder)
├── logs/ (empty folder)
├── index.php
├── en_index.php
├── sitemap.xml.php
├── robots.txt
├── .htaccess
├── 404.php
├── 500.php
└── maintenance.php
```

### 1.2 Configure config.php

**IMPORTANT:** Copy `config.sample.php` to `public/includes/config.php` and update:

```php
// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'u123456789_freshield');  // Your Hostinger DB name
define('DB_USER', 'u123456789_freshield');  // Your Hostinger DB user
define('DB_PASS', 'YOUR_DATABASE_PASSWORD');

// Environment
define('APP_ENV', 'production');  // MUST be 'production'

// Site URL
define('SITE_URL', 'https://freshield.com');

// Email (update with your credentials)
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_USERNAME', 'noreply@freshield.com');
define('SMTP_PASSWORD', 'YOUR_EMAIL_PASSWORD');
define('ADMIN_EMAIL', 'freshield@freshield.com');
```

---

## Step 2: Upload Files to Hostinger

### Option A: Using File Manager (Recommended for beginners)

1. **Log in to hPanel**
   - Go to https://hpanel.hostinger.com
   - Enter your credentials

2. **Access File Manager**
   - In hPanel, click on "File Manager"
   - Navigate to `public_html/` folder

3. **Upload Files**
   - Click "Upload" button
   - You can upload a ZIP file for faster transfer
   - If using ZIP:
     - Upload the zip file
     - Right-click → Extract
     - Move all files from extracted folder to `public_html/`

4. **Verify Structure**
   - Ensure `index.php` is in `public_html/`
   - All folders (public, admin, uploads, logs) are present

### Option B: Using FTP Client (FileZilla)

1. **Get FTP Credentials**
   - In hPanel → FTP Accounts
   - Note: Server, Username, Password, Port

2. **Connect via FileZilla**
   - Host: ftp.freshield.com (or IP from hPanel)
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21

3. **Upload Files**
   - Navigate to `public_html/` on remote server
   - Upload all files from your local deployment folder
   - Ensure proper structure is maintained

---

## Step 3: Create MySQL Database

1. **Access MySQL Databases**
   - In hPanel → Databases → MySQL Databases

2. **Create New Database**
   - Click "Create new database"
   - Database name: `freshield_db` (or `u123456789_freshield`)
   - Click "Create"

3. **Note Database Credentials**
   - Database name: `u123456789_freshield`
   - Username: `u123456789_freshield` (usually same as DB name)
   - Password: (the one you set)
   - Hostname: `localhost`

4. **Save Credentials**
   - You'll need these for config.php

---

## Step 4: Import Database Schema

### 4.1 Access phpMyAdmin

1. In hPanel → Databases → phpMyAdmin
2. Click on phpMyAdmin button
3. Select your database from left sidebar

### 4.2 Import Schema Files

1. **Import Main Schema**
   - Click "Import" tab
   - Choose file: `database/schema_freshield.sql`
   - Click "Go"
   - Wait for success message

2. **Import Phase 4 Additions**
   - Click "Import" tab again
   - Choose file: `database/schema_phase4_additions.sql`
   - Click "Go"
   - Verify tables are created

### 4.3 Verify Database

Check that these tables exist:
- `admins`
- `faqs`
- `manuals`
- `notices`
- `inquiries`
- `admin_logins`

---

## Step 5: Configure Application

### 5.1 Update config.php

Using File Manager or FTP:

1. Navigate to `public/includes/config.php`
2. Edit the file (right-click → Edit)
3. Update database credentials from Step 3
4. Set `APP_ENV` to `'production'`
5. Set `SITE_URL` to `'https://freshield.com'`
6. Save changes

### 5.2 Configure SMTP Email

**Option 1: Hostinger Email (Recommended)**

Create email account in hPanel:
1. Go to Emails → Email Accounts
2. Create: `noreply@freshield.com`
3. Set strong password
4. Update in config.php:

```php
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'noreply@freshield.com');
define('SMTP_PASSWORD', 'your-email-password');
define('SMTP_SECURE', 'tls');
```

**Option 2: Gmail SMTP**

If using Gmail:
1. Enable 2-factor authentication
2. Generate App Password
3. Update config.php:

```php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-gmail@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
```

---

## Step 6: Set File Permissions

### 6.1 Required Permissions

Set these permissions via File Manager (right-click → Permissions):

```
Directories:
/uploads/          → 755 (rwxr-xr-x)
/uploads/manuals/  → 755
/logs/             → 755

Files:
.htaccess          → 644 (rw-r--r--)
index.php          → 644
config.php         → 644 (IMPORTANT: not 777!)
All .php files     → 644
```

### 6.2 Security Check

**CRITICAL:** Ensure these files are NOT publicly accessible:
- `/public/includes/config.php` - protected by .htaccess
- `/database/` - protected by .htaccess
- `/logs/` - protected by .htaccess

Test by visiting:
- `https://freshield.com/public/includes/config.php` → Should show 403 Forbidden
- `https://freshield.com/database/` → Should show 403 Forbidden

---

## Step 7: SSL Certificate Setup

### 7.1 Install Free SSL (Let's Encrypt)

1. **Access SSL Settings**
   - In hPanel → SSL → Manage SSL

2. **Install SSL Certificate**
   - Select your domain: freshield.com
   - Choose "Install SSL"
   - Wait 10-15 minutes for activation

3. **Force HTTPS**
   - Already configured in `.htaccess`
   - Verify redirect works:
     - Visit: `http://freshield.com`
     - Should redirect to: `https://freshield.com`

### 7.2 Verify SSL

Check SSL certificate:
- Visit: https://www.ssllabs.com/ssltest/
- Enter: freshield.com
- Should get A or A+ rating

---

## Step 8: Domain DNS Configuration

### 8.1 Point Domain to Hostinger

If domain is registered elsewhere:

1. **Get Nameservers from Hostinger**
   - In hPanel → Domains
   - Note the nameservers:
     - ns1.dns-parking.com
     - ns2.dns-parking.com

2. **Update Domain Registrar**
   - Log in to your domain registrar
   - Find DNS/Nameserver settings
   - Replace with Hostinger nameservers
   - Save changes

3. **Wait for Propagation**
   - DNS changes take 24-48 hours
   - Check status: https://dnschecker.org

### 8.2 Verify Domain

Once DNS propagates:
- Visit: `https://freshield.com`
- Should load your website

---

## Step 9: Create Admin User

### 9.1 Access phpMyAdmin

1. Go to hPanel → phpMyAdmin
2. Select `freshield_db` database
3. Click on `admins` table

### 9.2 Insert Admin User

Click "Insert" tab and add:

```sql
username: admin
password_hash: [Use password_hash() - see below]
role: superadmin
```

**Generate Password Hash:**

Create temporary file `create_admin.php` in public_html:

```php
<?php
$password = 'YourSecurePassword123!';
echo password_hash($password, PASSWORD_DEFAULT);
// Copy the output hash
?>
```

1. Visit: `https://freshield.com/create_admin.php`
2. Copy the generated hash
3. Paste into password_hash field in phpMyAdmin
4. Click "Go" to insert
5. **DELETE `create_admin.php` immediately!**

### 9.3 Test Admin Login

1. Visit: `https://freshield.com/admin/`
2. Login with:
   - Username: admin
   - Password: YourSecurePassword123!
3. Should access dashboard

---

## Step 10: Final Testing

### 10.1 Test Checklist

Go through each item:

**Frontend:**
- ✅ Homepage loads (Korean)
- ✅ English homepage loads
- ✅ All menu links work
- ✅ Product pages load correctly
- ✅ Images display properly
- ✅ Contact form works
- ✅ FAQ pages load
- ✅ Manual download links work

**Contact Form:**
- ✅ Submit test inquiry
- ✅ Check if email received
- ✅ Verify inquiry in admin panel

**Admin Panel:**
- ✅ Login works
- ✅ Dashboard displays correctly
- ✅ FAQ management works
- ✅ Manual management works
- ✅ Inquiry management works
- ✅ File upload works

**Performance:**
- ✅ Page load speed < 3 seconds
- ✅ Images load with lazy loading
- ✅ CSS/JS minified in production

**Security:**
- ✅ HTTPS works (padlock icon)
- ✅ Config files not accessible
- ✅ Admin login requires credentials
- ✅ CSRF protection active

### 10.2 Test Tools

Use these tools:
- **PageSpeed Insights:** https://pagespeed.web.dev/
  - Target: Score > 85
- **SSL Test:** https://www.ssllabs.com/ssltest/
  - Target: A rating
- **Mobile Test:** https://search.google.com/test/mobile-friendly
  - Target: Mobile-friendly

---

## Post-Deployment

### 11.1 Monitor Logs

**Check error logs regularly:**

1. **Via File Manager:**
   - Navigate to `/logs/php-error.log`
   - Review for any errors
   - Download and analyze locally

2. **Via FTP:**
   - Download `/logs/php-error.log`
   - Open in text editor

**Set up monitoring:**
- Check logs weekly
- Set up email alerts for critical errors (optional)

### 11.2 Backup Strategy

**Automatic Backups (Hostinger):**
- Hostinger provides automatic backups
- Access: hPanel → Backups
- Frequency: Weekly (on most plans)

**Manual Backups:**
Perform monthly:
1. **Files:** Download entire `public_html/` via FTP
2. **Database:** Export via phpMyAdmin
3. Store locally and in cloud (Google Drive, Dropbox)

### 11.3 Maintenance Tasks

**Weekly:**
- Check inquiry submissions
- Review error logs
- Test contact form

**Monthly:**
- Update FAQs and manuals
- Review site performance
- Check for PHP/MySQL updates
- Perform manual backup

**Quarterly:**
- Security audit
- Performance optimization
- Content updates

---

## Troubleshooting

### Issue: "500 Internal Server Error"

**Causes & Solutions:**

1. **Incorrect file permissions**
   ```
   Solution: Set .htaccess to 644, directories to 755
   ```

2. **PHP syntax error**
   ```
   Solution: Check /logs/php-error.log for details
   Enable display_errors temporarily to see error
   ```

3. **Database connection failed**
   ```
   Solution: Verify config.php credentials match phpMyAdmin
   Test connection with simple script
   ```

### Issue: "Page Not Found" on admin

**Solution:**
- Verify .htaccess is uploaded and active
- Check mod_rewrite is enabled (Hostinger enables by default)
- Ensure admin folder exists in public_html/

### Issue: Contact form not sending emails

**Solutions:**

1. **SMTP credentials wrong**
   ```
   Check config.php SMTP settings
   Test email account login separately
   ```

2. **Port blocked**
   ```
   Try port 587 (TLS) or 465 (SSL)
   Update SMTP_PORT in config.php
   ```

3. **PHPMailer not found**
   ```
   Install via composer or use built-in mail()
   Mailer.php has fallback to mail()
   ```

### Issue: Images not displaying

**Solutions:**

1. **Wrong path**
   ```
   Check image src paths start with /public/assets/
   Verify images uploaded to correct folder
   ```

2. **File permissions**
   ```
   Set images folder to 755
   Set image files to 644
   ```

### Issue: CSS not loading / site looks broken

**Solutions:**

1. **Minified files missing**
   ```
   Run: php build_assets.php
   Upload generated dist/ folders
   ```

2. **Cache issue**
   ```
   Clear browser cache (Ctrl+Shift+R)
   Clear Hostinger cache if using CDN
   ```

3. **Wrong APP_ENV**
   ```
   Check config.php APP_ENV is set correctly
   'production' = uses minified
   'local' = uses regular files
   ```

### Issue: Admin login not working

**Solutions:**

1. **Password hash wrong**
   ```
   Regenerate password hash
   Update in database
   ```

2. **Session issues**
   ```
   Clear browser cookies
   Check session timeout settings
   Verify session folder is writable
   ```

---

## Support & Resources

### Hostinger Resources
- **Help Center:** https://support.hostinger.com
- **Live Chat:** Available 24/7 in hPanel
- **Video Tutorials:** https://www.hostinger.com/tutorials

### Application Support
- **Developer:** Contact developer for code issues
- **Documentation:** Refer to PHASE4_COMPLETION_REPORT.md

### Useful Links
- **PHP Documentation:** https://www.php.net/docs.php
- **MySQL Documentation:** https://dev.mysql.com/doc/
- **Hostinger Status:** https://status.hostinger.com/

---

## Security Best Practices

1. **Keep credentials secure**
   - Use strong passwords (min 16 characters)
   - Enable 2FA on Hostinger account
   - Never share database credentials

2. **Regular updates**
   - Keep PHP version updated in hPanel
   - Update application code as needed
   - Monitor security advisories

3. **Access control**
   - Limit admin accounts
   - Use role-based access
   - Monitor admin activity logs

4. **Backup religiously**
   - Automate backups
   - Test restore procedure
   - Keep multiple copies

5. **Monitor logs**
   - Check error logs weekly
   - Watch for suspicious activity
   - Set up alerts for critical errors

---

## Deployment Completion Checklist

Before considering deployment complete:

- ✅ All files uploaded successfully
- ✅ Database created and schema imported
- ✅ config.php configured with production settings
- ✅ File permissions set correctly
- ✅ SSL certificate installed and active
- ✅ Domain DNS pointing to Hostinger
- ✅ Admin user created and login works
- ✅ Contact form tested and emails working
- ✅ All frontend pages loading correctly
- ✅ All admin features tested
- ✅ Performance optimized (PageSpeed > 85)
- ✅ Security tested (SSL, file access)
- ✅ Backup strategy in place
- ✅ Monitoring configured
- ✅ Documentation reviewed

---

**Congratulations!** 🎉

Your Freshield website is now live on Hostinger!

For ongoing support and maintenance, refer to the Post-Deployment section and keep this guide handy for future reference.

---

**Last Updated:** November 15, 2025
**Version:** 1.0
**Phase:** 4 - Deployment Ready
