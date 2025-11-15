<?php
/**
 * Admin Logout
 * Phase 3: Admin Panel
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroy session
session_unset();
session_destroy();

// Delete session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to login page
header('Location: login.php');
exit;
?>
