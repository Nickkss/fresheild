# FRESHIELD.COM - COMPREHENSIVE TESTING CHECKLIST

## Testing Instructions
- Mark each item as ✅ (Pass), ❌ (Fail), or ⚠️ (Issue Found)
- Document any failures or issues in the "Notes" section
- Test systematically, one section at a time
- Record timestamps for performance tests

**Tester:** _________________
**Test Date:** _________________
**Environment:** _________________

---

## A. FRONT-END TESTING (KOREAN)

### A1. Homepage (index.php) - Korean

| Test Item | Status | Notes |
|-----------|--------|-------|
| Homepage loads without errors | ☐ | |
| Top logo displays correctly | ☐ | |
| Main navigation menu displays | ☐ | |
| Dropdown menus work on hover | ☐ | |
| Hero banner/slider works | ☐ | |
| All product images load | ☐ | |
| Footer displays correctly | ☐ | |
| Contact information visible | ☐ | |
| Language switcher works (KR ↔ EN) | ☐ | |
| No JavaScript console errors | ☐ | |
| Page meta title correct | ☐ | Expected: "후레쉴드 - Freshield \| 진공포장기 전문 브랜드" |
| Structured data (JSON-LD) present | ☐ | Check view-source for Organization schema |

### A2. Navigation & Menu Links - Korean

| Menu Item | Link Works | Loads Correctly | Notes |
|-----------|------------|-----------------|-------|
| 브랜드 → 브랜드소개 | ☐ | ☐ | |
| 브랜드 → 인증현황 | ☐ | ☐ | |
| 후레쉴드 → 진공포장기 → 아웃도어 | ☐ | ☐ | |
| 후레쉴드 → 진공포장기 → 어드밴스 | ☐ | ☐ | |
| 후레쉴드 → 진공포장기 → 엘리트 | ☐ | ☐ | |
| 후레쉴드 → 진공용기 → 제니시스 | ☐ | ☐ | |
| 후레쉴드 → 진공용기 → 핸드펌프 | ☐ | ☐ | |
| 후레쉴드 → 롤＆백 | ☐ | ☐ | |
| 활용 TIP | ☐ | ☐ | |
| 고객지원 → FAQ | ☐ | ☐ | |
| 고객지원 → 자료실 | ☐ | ☐ | |
| 문의하기 | ☐ | ☐ | Should load contact.php |

### A3. Product Pages - Korean

| Product Page | Images Load | Content Displays | Download Works | Notes |
|--------------|-------------|------------------|----------------|-------|
| 아웃도어 (Outdoor) | ☐ | ☐ | N/A | |
| 어드밴스 (Advance) | ☐ | ☐ | N/A | |
| 엘리트 (Elite) | ☐ | ☐ | N/A | |
| 제니시스 (Genisys) | ☐ | ☐ | N/A | |
| 핸드펌프 (Hand Pump) | ☐ | ☐ | N/A | |
| 롤앤백 (Roll & Bag) | ☐ | ☐ | N/A | |

### A4. Support Pages - Korean

**FAQ Page (faq.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Page loads correctly | ☐ | |
| FAQ items display | ☐ | |
| Accordion/expand works | ☐ | |
| No database errors | ☐ | |

**Manual Download Page (manual.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Page loads correctly | ☐ | |
| Manual list displays | ☐ | |
| Download buttons work | ☐ | |
| File download successful | ☐ | |
| Download count increments | ☐ | |

**Notice Board (notices.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Notice list page loads | ☐ | |
| Notices display correctly | ☐ | |
| NEW badge shows (< 7 days) | ☐ | |
| Pagination works | ☐ | |
| View count displays | ☐ | |
| Click notice opens detail | ☐ | |

### A5. Contact Form - Korean (contact.php)

**Form Display**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Form loads correctly | ☐ | |
| All fields visible | ☐ | Name, Company, Email, Phone, Product, Message |
| Required field indicators | ☐ | Red asterisks on required fields |
| Dropdown populated | ☐ | Product interest options |

**Form Validation - Client Side**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Submit with empty name → error | ☐ | |
| Submit with empty email → error | ☐ | |
| Submit with invalid email → error | ☐ | |
| Submit with empty message → error | ☐ | |

**Form Submission - Success**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Fill all required fields | ☐ | |
| Click submit | ☐ | |
| Success message displays | ☐ | |
| Confirmation email received | ☐ | Check inbox |
| Admin notification received | ☐ | Check admin email |
| Inquiry saved to database | ☐ | Check admin/inquiry_list.php |

**Form Submission - Failure Cases**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Submit without CSRF token → blocked | ☐ | |
| Submit with invalid email → error | ☐ | |
| Submit XSS attempt → sanitized | ☐ | Try: `<script>alert(1)</script>` |
| Network error handling | ☐ | |

---

## B. FRONT-END TESTING (ENGLISH)

### B1. Homepage (en_index.php) - English

| Test Item | Status | Notes |
|-----------|--------|-------|
| English homepage loads | ☐ | |
| All content in English | ☐ | |
| Menu navigation works | ☐ | |
| Language switcher (EN ↔ KR) | ☐ | |
| No JavaScript errors | ☐ | |
| Meta title correct | ☐ | Expected: "Freshield \| Premium Vacuum Sealer Brand" |
| Structured data present | ☐ | |

### B2. Navigation - English

| Menu Item | Link Works | Loads Correctly | Notes |
|-----------|------------|-----------------|-------|
| BRAND | ☐ | ☐ | |
| PRODUCTS → Vacuum sealers | ☐ | ☐ | |
| PRODUCTS → OUTDOOR | ☐ | ☐ | |
| PRODUCTS → ADVANCE | ☐ | ☐ | |
| PRODUCTS → ELITE | ☐ | ☐ | |
| PRODUCTS → Canisters | ☐ | ☐ | |
| PRODUCTS → GENISYS | ☐ | ☐ | |
| PRODUCTS → HAND PUMP | ☐ | ☐ | |
| PRODUCTS → Rolls & Bags | ☐ | ☐ | |
| TIPS | ☐ | ☐ | |
| SUPPORT → FAQ | ☐ | ☐ | |
| SUPPORT → Downloads | ☐ | ☐ | |
| CONTACT | ☐ | ☐ | Should load contact_en.php |

### B3. Support Pages - English

**FAQ Page (faq_en.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Page loads correctly | ☐ | |
| FAQ items in English | ☐ | |
| Functionality works | ☐ | |

**Manual Page (manual_en.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Page loads correctly | ☐ | |
| Downloads work | ☐ | |

**Contact Form (contact_en.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Form loads | ☐ | |
| All fields in English | ☐ | |
| Submit works | ☐ | |
| Success message in English | ☐ | |
| Email confirmation in English | ☐ | |

---

## C. ADMIN PANEL TESTING

### C1. Admin Login (admin/login.php)

**Basic Login**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Login page loads | ☐ | |
| Login with correct credentials | ☐ | Default: admin/admin123 |
| Redirect to dashboard | ☐ | |
| Session created | ☐ | |
| Username displayed in header | ☐ | |

**Failed Login Attempts**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Login with wrong password → error | ☐ | |
| Error message displays | ☐ | |
| Fail 1st attempt → no block | ☐ | |
| Fail 2nd attempt → no block | ☐ | |
| Fail 3rd attempt → 5 min block | ☐ | CRITICAL TEST |
| Block message displays | ☐ | Should show "5분 후에 다시 시도" |
| Login blocked during 5 min | ☐ | Try logging in again immediately |
| Block expires after 5 min | ☐ | Wait 5 minutes, try again |

**Extended Rate Limiting**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Fail 10 attempts → 60 min block | ☐ | CRITICAL TEST |
| Block message shows 60 min | ☐ | |
| admin_logins table populated | ☐ | Check database directly |
| IP address logged | ☐ | |
| Status = 'blocked' logged | ☐ | |

**Security**

| Test Item | Status | Notes |
|-----------|--------|-------|
| SQL injection attempt blocked | ☐ | Try: `admin' OR '1'='1` |
| XSS in username sanitized | ☐ | Try: `<script>alert(1)</script>` |
| Direct dashboard access blocked | ☐ | Visit /admin/dashboard.php without login |

### C2. Admin Dashboard (admin/dashboard.php)

| Test Item | Status | Notes |
|-----------|--------|-------|
| Dashboard loads after login | ☐ | |
| FAQ statistics display | ☐ | Korean + English counts |
| Manual statistics display | ☐ | Korean + English counts |
| **NEW: Inquiry statistics** | ☐ | New inquiries + Total count |
| **NEW: Recent inquiries widget** | ☐ | Shows last 5 inquiries |
| Recent FAQ widget | ☐ | Shows last 5 FAQs |
| Recent manuals widget | ☐ | Shows last 5 manuals |
| Quick action buttons work | ☐ | |
| No PHP errors | ☐ | |

### C3. FAQ Management

**FAQ List (admin/faq_list.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| FAQ list page loads | ☐ | |
| All FAQs display | ☐ | |
| Language filter works (ko/en) | ☐ | |
| Category filter works | ☐ | |
| Edit button works | ☐ | |
| Delete button works | ☐ | |
| "Add FAQ" button works | ☐ | |

**FAQ Create/Edit (admin/faq_edit.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Create new FAQ form loads | ☐ | |
| All fields editable | ☐ | Language, Category, Question, Answer |
| Save new FAQ works | ☐ | |
| FAQ appears in list | ☐ | |
| Edit existing FAQ loads | ☐ | |
| Update FAQ works | ☐ | |
| Changes reflected in list | ☐ | |
| CSRF protection works | ☐ | |
| Sort order works | ☐ | |
| Active/Inactive toggle | ☐ | |

**FAQ Delete (admin/faq_delete.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Delete confirmation page | ☐ | |
| Cancel returns to list | ☐ | |
| Confirm deletes FAQ | ☐ | |
| FAQ removed from list | ☐ | |
| CSRF protection works | ☐ | |

### C4. Manual Management

**Manual List (admin/manual_list.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Manual list displays | ☐ | |
| Language filter works | ☐ | |
| Category filter works | ☐ | |
| Download count displays | ☐ | |

**Manual Upload (admin/manual_edit.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Create manual form loads | ☐ | |
| File upload field present | ☐ | |
| Upload PDF file | ☐ | Max 10MB |
| File saved correctly | ☐ | Check /uploads/manuals/ |
| Manual appears in list | ☐ | |
| Download from frontend works | ☐ | |

**Manual File Replace**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Edit existing manual | ☐ | |
| Current file displayed | ☐ | |
| Upload replacement file | ☐ | |
| Old file deleted | ☐ | |
| New file saved | ☐ | |
| Download gets new file | ☐ | |

**Manual Delete**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Delete confirmation page | ☐ | |
| Delete removes file | ☐ | |
| Delete removes DB entry | ☐ | |

### C5. **NEW: Inquiry Management**

**Inquiry List (admin/inquiry_list.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Inquiry list page loads | ☐ | |
| All inquiries display | ☐ | |
| Status counts correct | ☐ | New, Read, Replied, Archived |
| Status filter works | ☐ | Filter by new/read/replied/archived |
| Search works | ☐ | Search by name/email/company/message |
| NEW badge displays | ☐ | On new inquiries |
| Status badges color-coded | ☐ | |
| Pagination works | ☐ | |

**Inquiry View (admin/inquiry_view.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Inquiry detail page loads | ☐ | |
| All inquiry data displays | ☐ | Name, email, phone, company, product, message |
| IP address logged | ☐ | |
| User agent logged | ☐ | |
| Status marked as 'read' | ☐ | Automatically on view |
| Status update works | ☐ | Change to replied/archived |
| Email reply link works | ☐ | Opens mailto: link |
| Phone link works (if mobile) | ☐ | |
| Print button works | ☐ | |
| Back to list works | ☐ | |

**Inquiry Delete (admin/inquiry_delete.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Delete confirmation shows | ☐ | |
| Inquiry details displayed | ☐ | |
| Cancel returns to view | ☐ | |
| Delete removes inquiry | ☐ | |
| Redirect to list works | ☐ | |

### C6. Admin User Management

**Admin List (admin/admins.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Admin list displays | ☐ | |
| All admins shown | ☐ | |
| Role displayed (superadmin/admin) | ☐ | |
| Edit button works | ☐ | |
| Delete button works | ☐ | |

**Admin Create/Edit (admin/admin_edit.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Create admin form loads | ☐ | |
| Username field works | ☐ | |
| Password field works | ☐ | |
| Role selection works | ☐ | |
| Save creates admin | ☐ | |
| Password hashed in DB | ☐ | Check database - NOT plain text |
| New admin can login | ☐ | |

**Admin Delete (admin/admin_delete.php)**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Delete confirmation | ☐ | |
| Cannot delete self | ☐ | Logged-in admin |
| Superadmin protection | ☐ | |

### C7. Session & Logout

**Session Timeout**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Login to admin panel | ☐ | |
| Wait 30 minutes idle | ☐ | Set timer |
| Try to access page | ☐ | |
| Redirected to login | ☐ | |
| Timeout message displays | ☐ | |

**Logout**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Click logout button | ☐ | |
| Redirected to login page | ☐ | |
| Session destroyed | ☐ | |
| Cannot access dashboard | ☐ | Try direct URL |
| Can login again | ☐ | |

### C8. CSRF Protection

| Test Item | Status | Notes |
|-----------|--------|-------|
| FAQ form has CSRF token | ☐ | Check HTML source |
| Manual form has CSRF token | ☐ | |
| Inquiry form has CSRF token | ☐ | |
| Submit without token → blocked | ☐ | Remove token in browser |
| Submit with wrong token → blocked | ☐ | Change token value |
| Valid token → success | ☐ | |

---

## D. MOBILE RESPONSIVENESS

### D1. iPhone Simulation (375x667 - iPhone 12/13/14)

**Homepage**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Page renders correctly | ☐ | |
| Logo visible | ☐ | |
| Menu hamburger icon | ☐ | |
| Menu opens/closes | ☐ | |
| Images fit screen | ☐ | No horizontal scroll |
| Text readable | ☐ | Font size appropriate |
| Buttons tappable | ☐ | Not too small |
| Footer displays | ☐ | |

**Product Pages**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Product images display | ☐ | |
| Text wraps correctly | ☐ | |
| Specifications readable | ☐ | |

**Contact Form**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Form fields full width | ☐ | |
| Keyboard doesn't cover inputs | ☐ | |
| Submit button visible | ☐ | |
| Form submits successfully | ☐ | |

### D2. Galaxy S20/S21/S22 (360x800)

| Test Item | Status | Notes |
|-----------|--------|-------|
| Homepage renders | ☐ | |
| Menu works | ☐ | |
| Images responsive | ☐ | |
| Touch targets adequate | ☐ | 44x44px minimum |
| No text cutoff | ☐ | |

### D3. iPad Mini / iPad 10.2 (768x1024)

| Test Item | Status | Notes |
|-----------|--------|-------|
| Tablet layout renders | ☐ | |
| Two-column layouts work | ☐ | |
| Images scale properly | ☐ | |
| Navigation appropriate | ☐ | |

### D4. Landscape Mode

| Device | Portrait OK | Landscape OK | Notes |
|--------|-------------|--------------|-------|
| iPhone 12 | ☐ | ☐ | |
| Galaxy S21 | ☐ | ☐ | |
| iPad Mini | ☐ | ☐ | |

---

## E. BROWSER COMPATIBILITY

### E1. Chrome (Latest)

| Test Item | Status | Version | Notes |
|-----------|--------|---------|-------|
| Homepage loads | ☐ | ____ | |
| All pages functional | ☐ | ____ | |
| Admin panel works | ☐ | ____ | |
| No console errors | ☐ | ____ | |

### E2. Microsoft Edge (Latest)

| Test Item | Status | Version | Notes |
|-----------|--------|---------|-------|
| Homepage loads | ☐ | ____ | |
| All pages functional | ☐ | ____ | |
| Admin panel works | ☐ | ____ | |
| No console errors | ☐ | ____ | |

### E3. Safari (Latest)

| Test Item | Status | Version | Notes |
|-----------|--------|---------|-------|
| Homepage loads | ☐ | ____ | macOS or iOS |
| All pages functional | ☐ | ____ | |
| Admin panel works | ☐ | ____ | |
| No console errors | ☐ | ____ | |

### E4. Firefox (Latest)

| Test Item | Status | Version | Notes |
|-----------|--------|---------|-------|
| Homepage loads | ☐ | ____ | |
| All pages functional | ☐ | ____ | |
| Admin panel works | ☐ | ____ | |
| No console errors | ☐ | ____ | |

---

## F. PERFORMANCE TESTING

### F1. Page Load Metrics

**Homepage (index.php)**

| Metric | Target | Actual | Status | Notes |
|--------|--------|--------|--------|-------|
| First Contentful Paint (FCP) | < 1.5s | ____ | ☐ | |
| Largest Contentful Paint (LCP) | < 2.5s | ____ | ☐ | |
| Time to Interactive (TTI) | < 3.5s | ____ | ☐ | |
| Total Page Load | < 3.0s | ____ | ☐ | |
| Total Page Size | < 2MB | ____ | ☐ | |

**Product Page**

| Metric | Target | Actual | Status | Notes |
|--------|--------|--------|--------|-------|
| First Contentful Paint | < 1.5s | ____ | ☐ | |
| Total Page Load | < 3.0s | ____ | ☐ | |

### F2. Asset Optimization

**CSS Files**

| File | Size | Minified? | Status | Notes |
|------|------|-----------|--------|-------|
| layout.min.css | ____ KB | ☐ | ☐ | Check /public/assets/css/dist/ |
| theme.min.css | ____ KB | ☐ | ☐ | |
| components.min.css | ____ KB | ☐ | ☐ | |
| vendor.min.css | ____ KB | ☐ | ☐ | |

**JavaScript Files**

| File | Size | Minified? | Status | Notes |
|------|------|-----------|--------|-------|
| main.min.js | ____ KB | ☐ | ☐ | Check /public/assets/js/dist/ |

**Production Mode Check**

| Test Item | Status | Notes |
|-----------|--------|-------|
| APP_ENV set to 'production' | ☐ | Check config.php |
| Minified CSS loaded (not original) | ☐ | View page source |
| Minified JS loaded (not original) | ☐ | View page source |
| Error display disabled | ☐ | Trigger error, should not show |
| Error logging to /logs/ | ☐ | Check /logs/php-error.log |

### F3. Image Optimization

| Test Item | Status | Notes |
|-----------|--------|-------|
| Hero banner < 200KB | ☐ | |
| Product images < 100KB each | ☐ | |
| Logo < 50KB | ☐ | |
| Total image weight acceptable | ☐ | < 1MB for page |

### F4. GZIP Compression

| Test Item | Status | Notes |
|-----------|--------|-------|
| GZIP enabled in .htaccess | ☐ | |
| HTML compressed | ☐ | Check network tab |
| CSS compressed | ☐ | Check Content-Encoding: gzip |
| JS compressed | ☐ | |
| Compression ratio > 70% | ☐ | |

**How to Check:**
1. Open browser DevTools (F12)
2. Go to Network tab
3. Reload page
4. Check any CSS/JS file
5. Look for "Content-Encoding: gzip" header

### F5. Lighthouse Scores

**Desktop**

| Metric | Target | Actual | Status | Notes |
|--------|--------|--------|--------|-------|
| Performance | > 90 | ____ | ☐ | |
| Accessibility | > 90 | ☐ | ____ | |
| Best Practices | > 90 | ____ | ☐ | |
| SEO | > 90 | ____ | ☐ | |

**Mobile**

| Metric | Target | Actual | Status | Notes |
|--------|--------|--------|--------|-------|
| Performance | > 85 | ____ | ☐ | |
| Accessibility | > 90 | ____ | ☐ | |
| Best Practices | > 90 | ____ | ☐ | |
| SEO | > 90 | ____ | ☐ | |

**How to Run Lighthouse:**
1. Open Chrome DevTools (F12)
2. Click "Lighthouse" tab
3. Select "Desktop" or "Mobile"
4. Click "Generate report"

### F6. Caching Headers

| Resource Type | Cache Duration | Verified | Notes |
|---------------|----------------|----------|-------|
| Images | 1 year | ☐ | Check Cache-Control header |
| Fonts | 1 year | ☐ | |
| CSS | 1 month | ☐ | |
| JavaScript | 1 month | ☐ | |

---

## G. SECURITY TESTING

### G1. Authentication & Authorization

**Access Control**

| Test Item | Status | Notes |
|-----------|--------|-------|
| /admin/ redirects to login | ☐ | Without session |
| Dashboard blocked without login | ☐ | |
| FAQ edit blocked without login | ☐ | |
| Manual upload blocked without login | ☐ | |
| Inquiry list blocked without login | ☐ | |
| Admin pages require superadmin | ☐ | Role-based access |

### G2. CSRF Protection

**Test CSRF Tokens**

| Form | Has Token | Submission Without Token | Status | Notes |
|------|-----------|--------------------------|--------|-------|
| Contact form | ☐ | ☐ Blocked | ☐ | |
| FAQ create/edit | ☐ | ☐ Blocked | ☐ | |
| Manual upload | ☐ | ☐ Blocked | ☐ | |
| Admin create | ☐ | ☐ Blocked | ☐ | |
| Inquiry delete | ☐ | ☐ Blocked | ☐ | |

**How to Test:**
1. Open form in browser
2. Right-click → Inspect Element
3. Find and delete `<input name="csrf_token">`
4. Submit form
5. Should be rejected with error

### G3. SQL Injection Prevention

**Test SQL Injection**

| Input Field | Test Payload | Blocked? | Status | Notes |
|-------------|--------------|----------|--------|-------|
| Admin login username | `admin' OR '1'='1` | ☐ | ☐ | |
| Admin login password | `' OR 1=1--` | ☐ | ☐ | |
| Contact form email | `test@test.com' OR '1'='1` | ☐ | ☐ | |
| FAQ search | `' UNION SELECT * FROM admins--` | ☐ | ☐ | |

**Expected Result:** All should be safely escaped, no SQL errors

### G4. XSS (Cross-Site Scripting) Prevention

**Test XSS Attacks**

| Input Field | Test Payload | Sanitized? | Status | Notes |
|-------------|--------------|------------|--------|-------|
| Contact name | `<script>alert('XSS')</script>` | ☐ | ☐ | |
| Contact message | `<img src=x onerror=alert(1)>` | ☐ | ☐ | |
| FAQ question | `<script>alert(document.cookie)</script>` | ☐ | ☐ | |
| Manual title | `<iframe src="evil.com">` | ☐ | ☐ | |

**Expected Result:** HTML tags escaped/stripped, no script execution

### G5. File Upload Security

**Manual Upload Validation**

| Test File | Expected Result | Actual | Status | Notes |
|-----------|-----------------|--------|--------|-------|
| valid.pdf (5MB) | ✅ Accepted | | ☐ | |
| valid.pdf (15MB) | ❌ Rejected (> 10MB) | | ☐ | |
| malicious.php | ❌ Rejected (wrong type) | | ☐ | |
| virus.exe | ❌ Rejected (wrong type) | | ☐ | |
| fake.pdf.php | ❌ Rejected (double ext) | | ☐ | |
| script.html | ❌ Rejected (wrong type) | | ☐ | |

**Upload Directory Protection**

| Test Item | Status | Notes |
|-----------|--------|-------|
| /uploads/ has .htaccess | ☐ | Blocks PHP execution |
| Cannot execute uploaded PHP | ☐ | Try accessing uploaded .php |
| Directory listing disabled | ☐ | Visit /uploads/ directly |

### G6. Directory Traversal

**Test Path Traversal**

| Test URL | Blocked? | Status | Notes |
|----------|----------|--------|-------|
| `/admin/../config.php` | ☐ | ☐ | |
| `/manual.php?file=../../config.php` | ☐ | ☐ | |
| `/download.php?file=../../../etc/passwd` | ☐ | ☐ | |

**Expected Result:** All blocked, cannot access files outside allowed directories

### G7. Sensitive File Protection

**Test File Access**

| File/Directory | Should Be | Status | Notes |
|----------------|-----------|--------|-------|
| /public/includes/config.php | 403 Forbidden | ☐ | |
| /database/ | 403 Forbidden | ☐ | |
| /database/schema_freshield.sql | 403 Forbidden | ☐ | |
| /logs/ | 403 Forbidden | ☐ | |
| /logs/php-error.log | 403 Forbidden | ☐ | |
| /.htaccess | 403 Forbidden | ☐ | |
| /.env (if exists) | 403 Forbidden | ☐ | |
| /.git/ | 403 Forbidden | ☐ | |

**How to Test:**
Visit: `https://your-domain.com/path-to-file`
Should show "403 Forbidden"

### G8. Security Headers

**Check HTTP Headers**

| Header | Expected Value | Present? | Status | Notes |
|--------|----------------|----------|--------|-------|
| X-Frame-Options | SAMEORIGIN | ☐ | ☐ | |
| X-Content-Type-Options | nosniff | ☐ | ☐ | |
| X-XSS-Protection | 1; mode=block | ☐ | ☐ | |
| Referrer-Policy | strict-origin-when-cross-origin | ☐ | ☐ | |
| Permissions-Policy | geolocation=(), microphone=(), camera=() | ☐ | ☐ | |

**How to Check:**
1. Open DevTools (F12) → Network tab
2. Reload page
3. Click on main document
4. Check "Response Headers"

### G9. Session Security

| Test Item | Status | Notes |
|-----------|--------|-------|
| Session cookies HttpOnly | ☐ | Prevents JavaScript access |
| Session cookies Secure (HTTPS) | ☐ | Production only |
| Session ID regenerated on login | ☐ | Prevents fixation |
| Session timeout after 30 min | ☐ | |
| Session destroyed on logout | ☐ | |

### G10. Information Disclosure

**Error Handling**

| Test Item | Status | Notes |
|-----------|--------|-------|
| PHP errors hidden in production | ☐ | Set APP_ENV='production' |
| Database errors don't show details | ☐ | Generic error messages |
| Stack traces hidden | ☐ | |
| Debug info not in HTML source | ☐ | |
| No version info in headers | ☐ | Server, PHP version hidden |

**Test by:**
1. Set APP_ENV to 'production'
2. Trigger an error (e.g., visit nonexistent page with .php)
3. Should show friendly error, not stack trace

---

## H. SEO TESTING

### H1. Meta Tags

**Homepage Korean**

| Meta Tag | Present | Content Correct | Status | Notes |
|----------|---------|-----------------|--------|-------|
| `<title>` | ☐ | ☐ | ☐ | "후레쉴드 - Freshield \| 진공포장기 전문 브랜드" |
| `<meta description>` | ☐ | ☐ | ☐ | About vacuum sealers |
| `<meta keywords>` | ☐ | ☐ | ☐ | |
| `<link rel="canonical">` | ☐ | ☐ | ☐ | |
| `<meta property="og:title">` | ☐ | ☐ | ☐ | Open Graph |
| `<meta property="og:description">` | ☐ | ☐ | ☐ | |
| `<meta property="og:image">` | ☐ | ☐ | ☐ | |
| `<meta property="og:url">` | ☐ | ☐ | ☐ | |
| `<meta name="twitter:card">` | ☐ | ☐ | ☐ | |

**Homepage English**

| Meta Tag | Present | Content Correct | Status | Notes |
|----------|---------|-----------------|--------|-------|
| `<title>` | ☐ | ☐ | ☐ | "Freshield \| Premium Vacuum Sealer Brand" |
| All other meta tags | ☐ | ☐ | ☐ | |

### H2. Structured Data (JSON-LD)

**Test Structured Data**

| Page | Schema Type | Present | Valid | Status | Notes |
|------|-------------|---------|-------|--------|-------|
| Homepage KR | Organization | ☐ | ☐ | ☐ | |
| Homepage EN | Organization | ☐ | ☐ | ☐ | |

**How to Validate:**
1. View page source
2. Find `<script type="application/ld+json">`
3. Copy JSON content
4. Go to: https://search.google.com/test/rich-results
5. Paste and test

### H3. Sitemap & Robots

| Test Item | Status | Notes |
|-----------|--------|-------|
| /sitemap.xml.php loads | ☐ | |
| Sitemap is valid XML | ☐ | |
| All pages included | ☐ | KR + EN pages |
| lastmod dates present | ☐ | |
| priorities set | ☐ | |
| /robots.txt exists | ☐ | |
| Sitemap referenced in robots.txt | ☐ | |
| Admin area blocked in robots | ☐ | Disallow: /admin/ |

**Validate Sitemap:**
Visit: https://www.xml-sitemaps.com/validate-xml-sitemap.html

### H4. URL Structure

| Test Item | Status | Notes |
|-----------|--------|-------|
| URLs are clean (no ?page= etc) | ☐ | |
| HTTPS enforced | ☐ | HTTP redirects to HTTPS |
| www vs non-www consistent | ☐ | |
| Trailing slash consistent | ☐ | |

---

## I. ACCESSIBILITY TESTING

### I1. Keyboard Navigation

| Test Item | Status | Notes |
|-----------|--------|-------|
| Tab through all links | ☐ | |
| Focus indicators visible | ☐ | |
| Can submit forms with keyboard | ☐ | |
| Menu accessible via keyboard | ☐ | |
| Skip to content link | ☐ | Optional but recommended |

### I2. Screen Reader Compatibility

| Test Item | Status | Notes |
|-----------|--------|-------|
| All images have alt text | ☐ | |
| Form labels present | ☐ | |
| Semantic HTML used | ☐ | `<header>`, `<nav>`, `<main>`, `<footer>` |
| ARIA labels where needed | ☐ | |

### I3. Color Contrast

| Test Item | Status | Notes |
|-----------|--------|-------|
| Text contrast ratio > 4.5:1 | ☐ | Normal text |
| Heading contrast ratio > 4.5:1 | ☐ | |
| Button contrast adequate | ☐ | |
| Link color distinguishable | ☐ | |

**Test Tool:** https://webaim.org/resources/contrastchecker/

---

## J. ERROR PAGES

### J1. 404 Error Page

| Test Item | Status | Notes |
|-----------|--------|-------|
| Visit non-existent page | ☐ | e.g., /nonexistent.php |
| Custom 404 page displays | ☐ | Not default server error |
| HTTP 404 status returned | ☐ | Check network tab |
| Language detected (KR/EN) | ☐ | |
| Helpful links provided | ☐ | Home, Products, Contact |
| Error logged | ☐ | Check /logs/php-error.log |
| Design matches site | ☐ | |

### J2. 500 Error Page

| Test Item | Status | Notes |
|-----------|--------|-------|
| Trigger 500 error | ☐ | Cause PHP fatal error |
| Custom 500 page displays | ☐ | |
| HTTP 500 status returned | ☐ | |
| Language detected | ☐ | |
| User-friendly message | ☐ | No technical details |
| Error logged | ☐ | |

### J3. Maintenance Mode

| Test Item | Status | Notes |
|-----------|--------|-------|
| Uncomment maintenance in .htaccess | ☐ | |
| Visit site | ☐ | |
| Maintenance page displays | ☐ | |
| HTTP 503 status returned | ☐ | |
| Retry-After header present | ☐ | |
| Language toggle works | ☐ | |
| Admin can still access via IP | ☐ | If whitelisted |
| Re-enable site works | ☐ | Comment out maintenance |

---

## K. DATABASE & DATA INTEGRITY

### K1. Database Connection

| Test Item | Status | Notes |
|-----------|--------|-------|
| Database connection successful | ☐ | |
| All tables present | ☐ | admins, faqs, manuals, notices, inquiries, admin_logins |
| Character encoding UTF-8 | ☐ | |
| Korean characters display | ☐ | |
| Emojis supported | ☐ | If used |

### K2. Data Validation

| Test Item | Status | Notes |
|-----------|--------|-------|
| Email validation works | ☐ | Invalid emails rejected |
| Date formats consistent | ☐ | |
| Required fields enforced | ☐ | |
| Max lengths respected | ☐ | |
| Unique constraints work | ☐ | e.g., admin username |

---

## L. EMAIL FUNCTIONALITY

### L1. Contact Form Emails

| Test Item | Status | Notes |
|-----------|--------|-------|
| Submit inquiry form | ☐ | |
| Admin notification received | ☐ | Check: ADMIN_EMAIL inbox |
| Customer confirmation received | ☐ | Check: submitted email |
| Email formatting correct (HTML) | ☐ | |
| All inquiry details included | ☐ | |
| Email in correct language | ☐ | KR form → KR email |
| Links in email work | ☐ | |
| From address correct | ☐ | noreply@freshield.com |

### L2. Email Delivery

| Test Item | Status | Notes |
|-----------|--------|-------|
| Emails not in spam | ☐ | Check spam folder |
| SMTP connection works | ☐ | No connection errors |
| Fallback to mail() works | ☐ | If SMTP fails |
| Email logs present | ☐ | If logging enabled |

---

## M. ADDITIONAL TESTS

### M1. Page Specific Tests

**Brand Story Page**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Page loads | ☐ | brandstory.php / brandstory_en.php |
| Content displays | ☐ | |
| Images load | ☐ | |

**Certification Page**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Page loads | ☐ | certification.php |
| Certificates display | ☐ | |

**Tips Page**

| Test Item | Status | Notes |
|-----------|--------|-------|
| Page loads | ☐ | tip.php / tip_en.php |
| Content displays | ☐ | |

### M2. Print Functionality

| Test Item | Status | Notes |
|-----------|--------|-------|
| Pages print correctly | ☐ | Test product page |
| Print-specific CSS works | ☐ | If implemented |
| Inquiry view prints well | ☐ | Admin panel |

### M3. Internationalization

| Test Item | Status | Notes |
|-----------|--------|-------|
| Korean characters display | ☐ | All pages |
| Date formats locale-aware | ☐ | |
| Number formats correct | ☐ | |
| Currency formats (if any) | ☐ | |

---

## N. TESTING SUMMARY

### Issue Log

| # | Page/Feature | Issue Description | Severity | Status | Notes |
|---|--------------|-------------------|----------|--------|-------|
| 1 | | | ☐ Critical ☐ High ☐ Medium ☐ Low | ☐ Open ☐ Fixed | |
| 2 | | | ☐ Critical ☐ High ☐ Medium ☐ Low | ☐ Open ☐ Fixed | |
| 3 | | | ☐ Critical ☐ High ☐ Medium ☐ Low | ☐ Open ☐ Fixed | |
| 4 | | | ☐ Critical ☐ High ☐ Medium ☐ Low | ☐ Open ☐ Fixed | |
| 5 | | | ☐ Critical ☐ High ☐ Medium ☐ Low | ☐ Open ☐ Fixed | |

### Overall Test Results

| Category | Total Tests | Passed | Failed | Pass Rate | Notes |
|----------|-------------|--------|--------|-----------|-------|
| Frontend (Korean) | | | | % | |
| Frontend (English) | | | | % | |
| Admin Panel | | | | % | |
| Mobile | | | | % | |
| Browsers | | | | % | |
| Performance | | | | % | |
| Security | | | | % | |
| SEO | | | | % | |
| **TOTAL** | | | | % | |

### Deployment Readiness

| Criteria | Met? | Notes |
|----------|------|-------|
| All critical tests passed | ☐ | |
| No blocker issues | ☐ | |
| Performance meets targets | ☐ | |
| Security tests passed | ☐ | |
| Mobile responsive | ☐ | |
| Browser compatible | ☐ | |
| SEO optimized | ☐ | |
| **READY FOR DEPLOYMENT** | ☐ | |

### Sign-Off

**Tested By:** _____________________
**Date:** _____________________
**Approved By:** _____________________
**Date:** _____________________

**Deployment Decision:** ☐ GO ☐ NO-GO

**Reason (if NO-GO):**
_____________________________________________
_____________________________________________
_____________________________________________

---

## O. POST-DEPLOYMENT VERIFICATION

### O1. Live Site Check (After Deployment)

| Test Item | Status | Notes |
|-----------|--------|-------|
| Domain resolves correctly | ☐ | freshield.com |
| HTTPS certificate valid | ☐ | No browser warnings |
| Homepage loads | ☐ | |
| Database connection works | ☐ | |
| File uploads work | ☐ | |
| Emails sending | ☐ | |
| Admin panel accessible | ☐ | |
| All pages functional | ☐ | |
| No console errors | ☐ | |
| Google Search Console submitted | ☐ | |
| Google Analytics tracking | ☐ | If installed |

---

**END OF TESTING CHECKLIST**

**Total Items:** 400+ test cases
**Estimated Testing Time:** 8-12 hours (comprehensive)
**Recommended:** Test in stages over 2-3 days

**Priority Testing Sequence:**
1. **Day 1:** Sections A, B, C (Frontend + Admin) - 4-5 hours
2. **Day 2:** Sections D, E, F (Mobile + Browsers + Performance) - 3-4 hours
3. **Day 3:** Sections G, H, I, J (Security + SEO + Accessibility + Errors) - 2-3 hours

---
