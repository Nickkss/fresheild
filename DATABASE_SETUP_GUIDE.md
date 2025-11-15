# Freshield Database Setup Guide

## Quick Start (3 Simple Steps)

### Step 1: Create the Database

Open your MySQL client (MySQL Workbench, phpMyAdmin, or command line) and run:

```sql
CREATE DATABASE freshield_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Step 2: Import the Schema

**Option A: Command Line**
```bash
mysql -u root -p freshield_db < database/schema_freshield.sql
```

**Option B: phpMyAdmin**
1. Select `freshield_db` database
2. Click "Import" tab
3. Choose file: `database/schema_freshield.sql`
4. Click "Go"

**Option C: MySQL Workbench**
1. Open `database/schema_freshield.sql`
2. Click Execute (lightning bolt icon)

---

### Step 3: Import Sample Data

**Option A: Command Line**
```bash
mysql -u root -p freshield_db < database/sample_data_freshield.sql
```

**Option B: phpMyAdmin**
1. Select `freshield_db` database
2. Click "Import" tab
3. Choose file: `database/sample_data_freshield.sql`
4. Click "Go"

**Option C: MySQL Workbench**
1. Open `database/sample_data_freshield.sql`
2. Click Execute (lightning bolt icon)

---

## Verify Installation

Run these queries to verify everything is set up correctly:

```sql
USE freshield_db;

-- Check all tables exist
SHOW TABLES;

-- Expected: admins, faqs, manuals, notices, inquiries

-- Check Korean FAQs
SELECT COUNT(*) FROM faqs WHERE language='ko';
-- Expected: 7

-- Check English FAQs
SELECT COUNT(*) FROM faqs WHERE language='en';
-- Expected: 7

-- Check Korean Manuals
SELECT COUNT(*) FROM manuals WHERE language='ko';
-- Expected: 7

-- Check English Manuals
SELECT COUNT(*) FROM manuals WHERE language='en';
-- Expected: 7

-- View sample FAQ
SELECT question, answer FROM faqs WHERE language='ko' LIMIT 1;

-- View sample Manual
SELECT title, description FROM manuals WHERE language='ko' LIMIT 1;
```

---

## Test the Website

### Start PHP Server:
```bash
cd d:\freshield.com
php -S localhost:8000
```

### Access Pages:
- **Korean Homepage:** http://localhost:8000/index.php
- **English Homepage:** http://localhost:8000/en_index.php

Navigate to FAQ and Downloads sections to see the database integration in action!

---

## Troubleshooting

### Problem: "Database Connection Error"

**Solution 1:** Check MySQL is running
```bash
# Windows
net start MySQL

# Or check services
services.msc
```

**Solution 2:** Verify database credentials in `public/includes/config.php`
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'freshield_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // Add your password if needed
```

**Solution 3:** Check database exists
```sql
SHOW DATABASES LIKE 'freshield_db';
```

---

### Problem: Korean text shows as "???" or boxes

**Solution:** Verify charset is utf8mb4
```sql
SELECT default_character_set_name
FROM information_schema.SCHEMATA
WHERE schema_name = 'freshield_db';

-- Should return: utf8mb4
```

If not, recreate database:
```sql
DROP DATABASE IF EXISTS freshield_db;
CREATE DATABASE freshield_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then re-import schema and data.

---

### Problem: FAQ/Manual pages show "No data available"

**Solution 1:** Check data was imported
```sql
SELECT COUNT(*) FROM faqs;
SELECT COUNT(*) FROM manuals;
```

**Solution 2:** Check `is_active` flag
```sql
UPDATE faqs SET is_active = 1;
UPDATE manuals SET is_active = 1;
```

**Solution 3:** Verify language codes
```sql
SELECT DISTINCT language FROM faqs;
SELECT DISTINCT language FROM manuals;
-- Should show: ko, en
```

---

## Configuration for Production

When deploying to production, update `public/includes/config.php`:

```php
// Change these values
define('DB_HOST', 'your-production-host.com');
define('DB_NAME', 'your_production_db_name');
define('DB_USER', 'your_production_user');
define('DB_PASS', 'your_secure_password');

// Set to production
define('APP_ENV', 'production');
```

---

## Database Backup

### Backup Command:
```bash
mysqldump -u root -p freshield_db > freshield_backup_2025-11-15.sql
```

### Restore from Backup:
```bash
mysql -u root -p freshield_db < freshield_backup_2025-11-15.sql
```

---

## Sample Queries for Testing

### View All Korean FAQs:
```sql
SELECT id, question, LEFT(answer, 50) as answer_preview
FROM faqs
WHERE language='ko' AND is_active=1
ORDER BY sort_order ASC;
```

### View All English Manuals:
```sql
SELECT id, title, file_size, download_count
FROM manuals
WHERE language='en' AND is_active=1
ORDER BY sort_order ASC;
```

### Search FAQs:
```sql
SELECT question, answer
FROM faqs
WHERE language='ko'
AND (question LIKE '%진공%' OR answer LIKE '%진공%')
AND is_active=1;
```

### Top Downloaded Manuals:
```sql
SELECT title, download_count
FROM manuals
WHERE language='ko' AND is_active=1
ORDER BY download_count DESC
LIMIT 5;
```

---

## Adding New Data (Manual Entry)

### Add a New FAQ:
```sql
INSERT INTO faqs (language, category, question, answer, sort_order, is_active)
VALUES (
    'ko',
    '제품사용',
    '새로운 질문?',
    '새로운 답변입니다.',
    10,
    1
);
```

### Add a New Manual:
```sql
INSERT INTO manuals (
    language, category, title, description,
    file_path, file_size, sort_order, is_active
)
VALUES (
    'ko',
    '사용설명서',
    '새로운 매뉴얼',
    '이것은 새로운 매뉴얼입니다.',
    '/uploads/manuals/new_manual.pdf',
    1234567,
    10,
    1
);
```

---

## Database Maintenance

### Check Table Sizes:
```sql
SELECT
    table_name AS 'Table',
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)'
FROM information_schema.TABLES
WHERE table_schema = 'freshield_db'
ORDER BY (data_length + index_length) DESC;
```

### Optimize Tables:
```sql
OPTIMIZE TABLE faqs;
OPTIMIZE TABLE manuals;
OPTIMIZE TABLE admins;
OPTIMIZE TABLE notices;
OPTIMIZE TABLE inquiries;
```

### Check for Inactive Records:
```sql
SELECT 'FAQs' as table_name, COUNT(*) as inactive_count
FROM faqs WHERE is_active = 0
UNION ALL
SELECT 'Manuals', COUNT(*)
FROM manuals WHERE is_active = 0;
```

---

## Need Help?

- **Full Documentation:** See `PHASE2_COMPLETION_REPORT.md`
- **Phase 1 Info:** See `PHASE1_COMPLETION_REPORT.md`
- **Quick Start:** See `QUICK_START_GUIDE.md`

---

**Database Version:** 1.0
**Last Updated:** November 15, 2025
**Status:** Production Ready ✅
