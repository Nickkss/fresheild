<?php
/**
 * Freshield Configuration File - SAMPLE
 *
 * IMPORTANT: This is a sample configuration file.
 *
 * DEPLOYMENT INSTRUCTIONS:
 * 1. Copy this file to /public/includes/config.php
 * 2. Update all values with your actual production credentials
 * 3. Set APP_ENV to 'production' for live server
 * 4. Never commit config.php to version control
 */

// ============================================================================
// DATABASE CONFIGURATION
// ============================================================================

// Database connection settings
// Update these with your Hostinger database credentials
define('DB_HOST', 'localhost');                    // Usually 'localhost' on Hostinger
define('DB_NAME', 'u123456789_freshield');         // Your database name from Hostinger
define('DB_USER', 'u123456789_freshield');         // Your database username from Hostinger
define('DB_PASS', 'YourSecurePassword123!');       // Your database password
define('DB_CHARSET', 'utf8mb4');                   // Keep as utf8mb4 for full Unicode support

// ============================================================================
// APPLICATION ENVIRONMENT
// ============================================================================

// Environment mode
// Options: 'local', 'development', 'staging', 'production'
// IMPORTANT: Set to 'production' for live server!
define('APP_ENV', 'production');

// ============================================================================
// PATHS
// ============================================================================

// Define base paths
define('BASE_PATH', __DIR__);
define('PUBLIC_PATH', BASE_PATH . '/public');
define('ASSETS_PATH', '/public/assets');
define('LOG_PATH', BASE_PATH . '/logs');

// ============================================================================
// ERROR HANDLING AND LOGGING
// ============================================================================

// Error handling based on environment
if (APP_ENV === 'production' || APP_ENV === 'staging') {
    // Production: Hide errors, log to file
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', LOG_PATH . '/php-error.log');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
} else {
    // Development: Show all errors
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// ============================================================================
// SITE SETTINGS
// ============================================================================

// Application settings
define('SITE_NAME', 'Freshield');
define('SITE_URL', 'https://freshield.com');        // Your production domain

// Language settings
define('DEFAULT_LANG', 'ko');
define('AVAILABLE_LANGS', ['ko', 'en']);

// ============================================================================
// UPLOAD SETTINGS
// ============================================================================

// Upload paths and limits
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('MANUAL_UPLOAD_PATH', UPLOAD_PATH . '/manuals');
define('MAX_UPLOAD_SIZE', 10485760);                 // 10MB in bytes

// ============================================================================
// EMAIL CONFIGURATION (SMTP)
// ============================================================================

// SMTP settings for sending emails
// For Hostinger, you can use their SMTP or Gmail SMTP

// Option 1: Hostinger SMTP (Recommended)
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'noreply@freshield.com');    // Create this email in Hostinger
define('SMTP_PASSWORD', 'YourEmailPassword123!');    // Email password
define('SMTP_FROM_EMAIL', 'noreply@freshield.com');
define('SMTP_FROM_NAME', 'Freshield');
define('SMTP_SECURE', 'tls');                        // 'tls' or 'ssl'

// Option 2: Gmail SMTP (Alternative)
// define('SMTP_HOST', 'smtp.gmail.com');
// define('SMTP_PORT', 587);
// define('SMTP_USERNAME', 'your-gmail@gmail.com');
// define('SMTP_PASSWORD', 'your-app-specific-password');  // Use App Password, not regular password
// define('SMTP_FROM_EMAIL', 'your-gmail@gmail.com');
// define('SMTP_FROM_NAME', 'Freshield');
// define('SMTP_SECURE', 'tls');

// Admin notification email
define('ADMIN_EMAIL', 'freshield@freshield.com');    // Where inquiry notifications are sent

// ============================================================================
// SECURITY SETTINGS
// ============================================================================

// Session timeout (30 minutes = 1800 seconds)
define('SESSION_TIMEOUT', 1800);

// Login security
define('LOGIN_MAX_ATTEMPTS', 3);                     // Maximum failed login attempts
define('LOGIN_LOCKOUT_TIME', 300);                   // Lockout duration in seconds (5 minutes)

// CSRF token expiry
define('CSRF_TOKEN_EXPIRY', 3600);                   // 1 hour in seconds

// ============================================================================
// PAGINATION
// ============================================================================

// Items per page in admin panel lists
define('ITEMS_PER_PAGE', 10);

// ============================================================================
// SESSION MANAGEMENT
// ============================================================================

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    // Configure session settings
    ini_set('session.cookie_httponly', 1);           // Prevent JavaScript access to session cookie
    ini_set('session.use_only_cookies', 1);          // Only use cookies for sessions
    ini_set('session.cookie_secure', APP_ENV === 'production' ? 1 : 0);  // HTTPS only in production

    session_start();

    // Set session timeout
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
        // Session expired
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['LAST_ACTIVITY'] = time();
}

// ============================================================================
// DEPLOYMENT CHECKLIST
// ============================================================================

/*
 * BEFORE GOING LIVE, VERIFY:
 *
 * ✅ Database credentials are correct
 * ✅ APP_ENV is set to 'production'
 * ✅ SITE_URL matches your domain
 * ✅ SMTP credentials are configured
 * ✅ ADMIN_EMAIL is correct
 * ✅ /logs directory exists and is writable (chmod 755)
 * ✅ /uploads directory exists and is writable (chmod 755)
 * ✅ Database schema is imported
 * ✅ Admin user is created
 * ✅ SSL certificate is installed
 * ✅ .htaccess file is in place
 * ✅ This file is renamed to config.php
 * ✅ File permissions are secure (644 for PHP files)
 *
 * SECURITY NOTES:
 * - Never commit config.php to version control
 * - Keep database credentials secure
 * - Use strong passwords for all accounts
 * - Regularly update PHP and MySQL
 * - Monitor error logs regularly
 */

?>
