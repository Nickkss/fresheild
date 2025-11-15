<?php
/**
 * Admin Authentication Check
 * Include this file at the top of every admin page (except login.php)
 *
 * Phase 3: Admin Panel Security
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_role'])) {
    // Not logged in - redirect to login page
    header('Location: /admin/login.php');
    exit;
}

// Prevent session fixation
if (!isset($_SESSION['admin_session_id'])) {
    $_SESSION['admin_session_id'] = session_id();
} elseif ($_SESSION['admin_session_id'] !== session_id()) {
    // Session ID mismatch - possible session hijacking
    session_destroy();
    header('Location: /admin/login.php');
    exit;
}

// Session timeout (30 minutes of inactivity)
$timeout = 1800; // 30 minutes in seconds
if (isset($_SESSION['admin_last_activity'])) {
    $elapsed = time() - $_SESSION['admin_last_activity'];
    if ($elapsed > $timeout) {
        // Session expired
        session_destroy();
        header('Location: /admin/login.php?timeout=1');
        exit;
    }
}

// Update last activity time
$_SESSION['admin_last_activity'] = time();

// Make current admin data available
$currentAdmin = [
    'id' => $_SESSION['admin_id'],
    'username' => $_SESSION['admin_username'] ?? 'Admin',
    'role' => $_SESSION['admin_role']
];

/**
 * Check if current admin has required role
 * @param string $requiredRole Required role ('admin' or 'superadmin')
 * @return bool True if authorized
 */
function requireRole(string $requiredRole): bool
{
    if (!isset($_SESSION['admin_role'])) {
        return false;
    }

    // Superadmin has access to everything
    if ($_SESSION['admin_role'] === 'superadmin') {
        return true;
    }

    // Check specific role
    return $_SESSION['admin_role'] === $requiredRole;
}

/**
 * Require superadmin role or redirect
 * @return void
 */
function requireSuperadmin(): void
{
    if (!requireRole('superadmin')) {
        header('Location: /admin/dashboard.php?error=access_denied');
        exit;
    }
}

?>
