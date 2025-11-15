<?php
/**
 * Freshield Configuration File
 *
 * This file will contain database connection settings
 * and other configuration variables in Phase 2
 *
 * Phase 1: Empty placeholder
 * Phase 2: Will add database credentials and settings
 */

// Define base paths
define('BASE_PATH', dirname(dirname(__DIR__)));
define('PUBLIC_PATH', BASE_PATH . '/public');
define('ASSETS_PATH', '/public/assets');

// Language settings
define('DEFAULT_LANG', 'ko');
define('AVAILABLE_LANGS', ['ko', 'en']);

// ============================================================================
// PHASE 2: Database Configuration
// ============================================================================

// Database connection settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'freshield_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application environment
// Options: 'local', 'development', 'staging', 'production'
define('APP_ENV', 'local');

// Paths
define('LOG_PATH', BASE_PATH . '/logs');

// Error handling and logging (based on environment)
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

// Application settings
define('SITE_NAME', 'Freshield');
define('SITE_URL', APP_ENV === 'production' ? 'https://freshield.com' : 'http://localhost:8000');

// Upload settings (for Phase 3)
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('MANUAL_UPLOAD_PATH', UPLOAD_PATH . '/manuals');
define('MAX_UPLOAD_SIZE', 10485760); // 10MB in bytes

// Pagination settings
define('ITEMS_PER_PAGE', 10);

// Email Configuration (SMTP)
// Update these values for production deployment
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', ''); // Your SMTP username
define('SMTP_PASSWORD', ''); // Your SMTP password
define('SMTP_FROM_EMAIL', 'noreply@freshield.com');
define('SMTP_FROM_NAME', 'Freshield');
define('ADMIN_EMAIL', 'freshield@freshield.com');
define('SMTP_SECURE', 'tls'); // 'tls' or 'ssl'

// Security Settings
define('SESSION_TIMEOUT', 1800); // 30 minutes in seconds
define('LOGIN_MAX_ATTEMPTS', 3);
define('LOGIN_LOCKOUT_TIME', 300); // 5 minutes in seconds
define('CSRF_TOKEN_EXPIRY', 3600); // 1 hour

// Session settings
if (session_status() === PHP_SESSION_NONE) {
    session_start();

    // Set session timeout
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['LAST_ACTIVITY'] = time();
}

?>

