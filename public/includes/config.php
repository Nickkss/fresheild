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

// Error display settings (based on environment)
if (APP_ENV === 'local' || APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}

// Application settings
define('SITE_NAME', 'Freshield');
define('SITE_URL', 'http://localhost:8000');

// Upload settings (for Phase 3)
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('MANUAL_UPLOAD_PATH', UPLOAD_PATH . '/manuals');
define('MAX_UPLOAD_SIZE', 10485760); // 10MB in bytes

// Pagination settings
define('ITEMS_PER_PAGE', 10);

// Session settings
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

