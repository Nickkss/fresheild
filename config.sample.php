<?php
/**
 * Freshield CMS - Production Configuration Template
 * Version: 1.0
 * Last Updated: November 15, 2025
 *
 * ============================================================================
 * DEPLOYMENT INSTRUCTIONS
 * ============================================================================
 *
 * 1. Copy this file to: /public/includes/config.php
 * 2. Update all credentials with your production values
 * 3. Set APP_ENV to 'production'
 * 4. Set proper file permissions: chmod 644 config.php
 * 5. Never commit config.php to version control
 *
 * ============================================================================
 * IMPORTANT SECURITY NOTES
 * ============================================================================
 *
 * - Use strong passwords (min 12 characters)
 * - Keep database credentials secure
 * - Enable HTTPS before going live
 * - Regularly monitor error logs
 * - Update PHP and MySQL regularly
 */

// ============================================================================
// APPLICATION VERSION
// ============================================================================

define('APP_VERSION', 'v1.0');                           // Freshield CMS Version
define('APP_BUILD_DATE', '2025-11-15');                  // Build date

// ============================================================================
// ENVIRONMENT CONFIGURATION
// ============================================================================

/**
 * Application Environment
 *
 * Options:
 * - 'local'       : Local development (show errors, use individual assets)
 * - 'development' : Development server (show errors, detailed logging)
 * - 'staging'     : Staging server (hide errors, log to file)
 * - 'production'  : Live production server (hide errors, optimized assets)
 *
 * IMPORTANT: Set to 'production' for live server!
 */
define('APP_ENV', 'production');

// ============================================================================
// TIMEZONE CONFIGURATION
// ============================================================================

/**
 * Default Timezone
 * For Korea, use 'Asia/Seoul'
 * See: https://www.php.net/manual/en/timezones.php
 */
date_default_timezone_set('Asia/Seoul');

// ============================================================================
// DATABASE CONFIGURATION
// ============================================================================

/**
 * Database Connection Settings
 * Update these with your Hostinger database credentials
 */
define('DB_HOST', 'localhost');                          // Usually 'localhost' on shared hosting
define('DB_NAME', 'u123456789_freshield');               // Your database name from Hostinger
define('DB_USER', 'u123456789_freshield');               // Your database username from Hostinger
define('DB_PASS', 'YourSecurePassword123!');             // Your database password (CHANGE THIS!)
define('DB_CHARSET', 'utf8mb4');                         // Full Unicode support (keep as is)

// ============================================================================
// DIRECTORY PATHS
// ============================================================================

/**
 * Application Paths
 * These are automatically configured - do not change unless necessary
 */
define('BASE_PATH', dirname(dirname(__DIR__)));          // Root directory
define('PUBLIC_PATH', BASE_PATH . '/public');            // Public web directory
define('ASSETS_PATH', '/public/assets');                 // Web path to assets
define('UPLOAD_DIR', BASE_PATH . '/uploads');            // Upload directory
define('LOG_DIR', BASE_PATH . '/logs');                  // Log directory

// Legacy aliases (for backward compatibility)
define('UPLOAD_PATH', UPLOAD_DIR);
define('LOG_PATH', LOG_DIR);

// Specific upload paths
define('MANUAL_UPLOAD_PATH', UPLOAD_DIR . '/manuals');   // Manual files directory

// ============================================================================
// ERROR HANDLING & LOGGING
// ============================================================================

/**
 * Production Environment: Hide errors, log to file
 * Development Environment: Show errors for debugging
 */
if (APP_ENV === 'production' || APP_ENV === 'staging') {
    // PRODUCTION MODE: Maximum security
    ini_set('display_errors', 0);                        // Never show errors to users
    ini_set('display_startup_errors', 0);
    ini_set('log_errors', 1);                            // Log errors to file
    ini_set('error_log', LOG_DIR . '/php-error.log');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

    // Additional production settings
    ini_set('expose_php', 0);                            // Hide PHP version
    ini_set('allow_url_fopen', 0);                       // Disable remote file access

} else {
    // DEVELOPMENT MODE: Full error reporting
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', LOG_DIR . '/php-error.log');
    error_reporting(E_ALL);
}

// ============================================================================
// SITE CONFIGURATION
// ============================================================================

/**
 * Site Information
 */
define('SITE_NAME', 'Freshield');
define('SITE_NAME_KR', '후레쉴드');
define('SITE_URL', APP_ENV === 'production' ? 'https://freshield.com' : 'http://localhost:8000');
define('SITE_DESCRIPTION', 'Premium Vacuum Sealer Brand');

// Language settings
define('DEFAULT_LANG', 'ko');                            // Default language (Korean)
define('AVAILABLE_LANGS', ['ko', 'en']);                 // Supported languages

// ============================================================================
// UPLOAD SETTINGS
// ============================================================================

/**
 * File Upload Configuration
 */
define('MAX_UPLOAD_SIZE', 10485760);                     // 10 MB in bytes (10 * 1024 * 1024)
define('ALLOWED_FILE_TYPES', [
    'application/pdf',
    'image/jpeg',
    'image/jpg',
    'image/png',
    'image/gif',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]);

// ============================================================================
// EMAIL CONFIGURATION (SMTP)
// ============================================================================

/**
 * SMTP Settings for Email Delivery
 *
 * OPTION 1: Hostinger SMTP (Recommended for production)
 * OPTION 2: Gmail SMTP (For testing or alternative)
 */

// === HOSTINGER SMTP (RECOMMENDED) ===
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'noreply@freshield.com');        // Create this email in Hostinger cPanel
define('SMTP_PASSWORD', 'YourEmailPassword123!');        // Email account password (CHANGE THIS!)
define('SMTP_FROM_EMAIL', 'noreply@freshield.com');
define('SMTP_FROM_NAME', 'Freshield');
define('SMTP_SECURE', 'tls');                            // 'tls' (port 587) or 'ssl' (port 465)

// === GMAIL SMTP (ALTERNATIVE) ===
// Uncomment below to use Gmail instead
// NOTE: Use App Password, not regular Gmail password
// Generate at: https://myaccount.google.com/apppasswords
/*
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-specific-password');   // 16-character app password
define('SMTP_FROM_EMAIL', 'your-email@gmail.com');
define('SMTP_FROM_NAME', 'Freshield');
define('SMTP_SECURE', 'tls');
*/

// Admin notification settings
define('ADMIN_EMAIL', 'freshield@freshield.com');        // Where to send inquiry notifications
define('ADMIN_EMAIL_NAME', 'Freshield Admin');

// ============================================================================
// SECURITY SETTINGS
// ============================================================================

/**
 * Session Security
 */
define('SESSION_TIMEOUT', 1800);                         // 30 minutes in seconds (30 * 60)
define('SESSION_NAME', 'FRESHIELD_SESSION');             // Custom session name

/**
 * Login Rate Limiting
 */
define('LOGIN_MAX_ATTEMPTS', 3);                         // Max failed attempts before lockout
define('LOGIN_LOCKOUT_TIME', 300);                       // 5 minutes lockout (5 * 60)
define('LOGIN_EXTENDED_LOCKOUT_ATTEMPTS', 10);           // Attempts before extended lockout
define('LOGIN_EXTENDED_LOCKOUT_TIME', 3600);             // 60 minutes extended lockout (60 * 60)

/**
 * CSRF Protection
 */
define('CSRF_TOKEN_EXPIRY', 3600);                       // 1 hour in seconds
define('CSRF_TOKEN_LENGTH', 32);                         // Token length in bytes

/**
 * Password Requirements
 */
define('PASSWORD_MIN_LENGTH', 8);                        // Minimum password length
define('PASSWORD_REQUIRE_UPPERCASE', true);              // Require uppercase letters
define('PASSWORD_REQUIRE_LOWERCASE', true);              // Require lowercase letters
define('PASSWORD_REQUIRE_NUMBERS', true);                // Require numbers
define('PASSWORD_REQUIRE_SPECIAL', false);               // Require special characters

// ============================================================================
// PAGINATION & DISPLAY
// ============================================================================

/**
 * Admin Panel Settings
 */
define('ITEMS_PER_PAGE', 10);                            // Items per page in admin lists
define('ADMIN_RECENT_ITEMS', 5);                         // Recent items in dashboard widgets

/**
 * Frontend Settings
 */
define('NOTICES_PER_PAGE', 10);                          // Notices per page
define('FAQS_PER_PAGE', 20);                             // FAQs per page
define('MANUALS_PER_PAGE', 20);                          // Manuals per page

// ============================================================================
// CACHE & PERFORMANCE
// ============================================================================

/**
 * Asset Optimization
 * Automatically uses minified assets in production
 */
define('USE_MINIFIED_ASSETS', APP_ENV === 'production' || APP_ENV === 'staging');

/**
 * Cache Settings
 */
define('ENABLE_CACHE', APP_ENV === 'production');        // Enable caching in production
define('CACHE_LIFETIME', 3600);                          // Cache lifetime in seconds (1 hour)

// ============================================================================
// SESSION MANAGEMENT
// ============================================================================

/**
 * Start and configure session
 */
if (session_status() === PHP_SESSION_NONE) {
    // Session security settings
    ini_set('session.cookie_httponly', 1);               // Prevent JavaScript access to cookies
    ini_set('session.use_only_cookies', 1);              // Only use cookies (no URL parameters)
    ini_set('session.cookie_secure', APP_ENV === 'production' ? 1 : 0);  // HTTPS only in production
    ini_set('session.cookie_samesite', 'Strict');        // CSRF protection
    ini_set('session.use_strict_mode', 1);               // Prevent session fixation

    // Set custom session name
    session_name(SESSION_NAME);

    // Start session
    session_start();

    // Session timeout check
    if (isset($_SESSION['LAST_ACTIVITY'])) {
        if ((time() - $_SESSION['LAST_ACTIVITY']) > SESSION_TIMEOUT) {
            // Session expired
            session_unset();
            session_destroy();
            session_start();
        }
    }

    // Update last activity timestamp
    $_SESSION['LAST_ACTIVITY'] = time();

    // Session regeneration for security (every 30 minutes)
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 1800) {
        // Regenerate session ID
        session_regenerate_id(true);
        $_SESSION['CREATED'] = time();
    }
}

// ============================================================================
// MAINTENANCE MODE
// ============================================================================

/**
 * Maintenance Mode
 * Set to true to enable maintenance mode
 */
define('MAINTENANCE_MODE', false);

// Allowed IPs during maintenance (admin access)
define('MAINTENANCE_ALLOWED_IPS', [
    '127.0.0.1',                                         // Localhost
    '::1',                                               // Localhost IPv6
    // 'YOUR.IP.ADDRESS.HERE',                           // Add your IP here
]);

// Check maintenance mode (except for admin IPs)
if (MAINTENANCE_MODE && !in_array($_SERVER['REMOTE_ADDR'] ?? '', MAINTENANCE_ALLOWED_IPS)) {
    // Redirect to maintenance page (unless already there)
    if (basename($_SERVER['PHP_SELF']) !== 'maintenance.php') {
        header('Location: /maintenance.php');
        exit;
    }
}

// ============================================================================
// DEBUGGING & DEVELOPMENT
// ============================================================================

/**
 * Debug Mode (Development Only)
 * IMPORTANT: Set to false in production!
 */
define('DEBUG_MODE', APP_ENV !== 'production' && APP_ENV !== 'staging');

// Debug logging
if (DEBUG_MODE) {
    define('DEBUG_LOG_FILE', LOG_DIR . '/debug.log');
}

// ============================================================================
// CONSTANTS VALIDATION
// ============================================================================

/**
 * Ensure required directories exist
 */
$requiredDirs = [LOG_DIR, UPLOAD_DIR, MANUAL_UPLOAD_PATH];

foreach ($requiredDirs as $dir) {
    if (!file_exists($dir)) {
        @mkdir($dir, 0755, true);
    }

    // Ensure directory is writable
    if (!is_writable($dir)) {
        error_log("Warning: Directory not writable: $dir");
    }
}

// ============================================================================
// PRODUCTION DEPLOYMENT CHECKLIST
// ============================================================================

/*
 * ============================================================================
 * BEFORE GOING LIVE - VERIFY ALL ITEMS BELOW
 * ============================================================================
 *
 * DATABASE:
 * ✅ DB_HOST is correct (usually 'localhost')
 * ✅ DB_NAME matches your Hostinger database name
 * ✅ DB_USER matches your Hostinger database username
 * ✅ DB_PASS is set to a strong password
 * ✅ Database schema is imported successfully
 * ✅ Sample data is imported (if needed)
 *
 * ENVIRONMENT:
 * ✅ APP_ENV is set to 'production'
 * ✅ Timezone is set to 'Asia/Seoul' (or your timezone)
 * ✅ Error display is disabled (display_errors = 0)
 * ✅ Error logging is enabled to /logs directory
 *
 * PATHS & DIRECTORIES:
 * ✅ /logs directory exists (chmod 755)
 * ✅ /logs is writable by web server
 * ✅ /uploads directory exists (chmod 755)
 * ✅ /uploads is writable by web server
 * ✅ /uploads/manuals directory exists
 *
 * SITE SETTINGS:
 * ✅ SITE_URL matches your production domain
 * ✅ SITE_NAME is correct
 * ✅ Default language is set (ko for Korean)
 *
 * EMAIL CONFIGURATION:
 * ✅ SMTP_HOST is correct (smtp.hostinger.com)
 * ✅ SMTP_USERNAME is a valid email account
 * ✅ SMTP_PASSWORD is correct
 * ✅ SMTP_FROM_EMAIL is configured
 * ✅ ADMIN_EMAIL is correct
 * ✅ Test email sending works
 *
 * SECURITY:
 * ✅ This file is renamed to config.php
 * ✅ config.php has correct permissions (chmod 644)
 * ✅ config.php is NOT in version control (.gitignore)
 * ✅ .htaccess file is in place
 * ✅ Admin user is created with strong password
 * ✅ SESSION_TIMEOUT is appropriate (30 min default)
 * ✅ Rate limiting is configured (3 attempts = 5 min lockout)
 *
 * SSL & DOMAIN:
 * ✅ SSL certificate is installed and active
 * ✅ HTTPS redirect is enabled in .htaccess
 * ✅ Domain DNS points to correct server
 * ✅ www redirect is configured (if needed)
 *
 * PERFORMANCE:
 * ✅ Asset minification is working (CSS/JS)
 * ✅ GZIP compression is enabled (.htaccess)
 * ✅ Browser caching is configured (.htaccess)
 * ✅ PHP version is 7.4+ (8.0+ recommended)
 *
 * SEO:
 * ✅ robots.txt is in place
 * ✅ sitemap.xml.php is accessible
 * ✅ Meta tags are configured (index.php, en_index.php)
 * ✅ Structured data (JSON-LD) is in place
 *
 * TESTING:
 * ✅ Test homepage loads (Korean & English)
 * ✅ Test admin login works
 * ✅ Test contact form submission
 * ✅ Test email delivery (notification & confirmation)
 * ✅ Test all product pages load
 * ✅ Test FAQ and Manual pages
 * ✅ Test 404 and 500 error pages
 * ✅ Test on mobile devices
 * ✅ Test on multiple browsers
 * ✅ Run Lighthouse audit (target >90 score)
 *
 * POST-DEPLOYMENT:
 * ✅ Monitor error logs for first 24 hours
 * ✅ Submit sitemap to Google Search Console
 * ✅ Set up website monitoring (uptime)
 * ✅ Configure regular backups (daily recommended)
 * ✅ Document admin login credentials securely
 *
 * ============================================================================
 * SECURITY BEST PRACTICES
 * ============================================================================
 *
 * PASSWORDS:
 * - Use minimum 12 characters
 * - Include uppercase, lowercase, numbers, symbols
 * - Never use common words or patterns
 * - Change default admin password immediately
 * - Use different passwords for DB and email
 *
 * FILE PERMISSIONS:
 * - PHP files: 644 (rw-r--r--)
 * - Directories: 755 (rwxr-xr-x)
 * - config.php: 644 (readable by web server only)
 * - Never use 777 permissions
 *
 * REGULAR MAINTENANCE:
 * - Monitor error logs weekly
 * - Update PHP and MySQL regularly
 * - Review admin login attempts monthly
 * - Backup database daily
 * - Test backups monthly
 * - Review and update passwords quarterly
 *
 * MONITORING:
 * - Set up uptime monitoring (e.g., UptimeRobot)
 * - Monitor disk space usage
 * - Monitor error log file size
 * - Track website performance metrics
 * - Review contact form submissions regularly
 *
 * ============================================================================
 */

?>
