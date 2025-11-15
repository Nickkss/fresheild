<?php
/**
 * Freshield Database Connection and Helper Functions
 *
 * This file provides PDO database connection and helper functions
 * for accessing FAQ and Manual data from the database.
 *
 * Phase 2: Database foundation layer
 *
 * @package Freshield
 * @version 1.0
 */

// Include configuration
require_once __DIR__ . '/config.php';

// ============================================================================
// Global PDO instance
// ============================================================================

$pdo = null;

/**
 * Get PDO database connection instance
 *
 * Creates and returns a PDO connection using configuration constants.
 * Uses singleton pattern to reuse the same connection.
 *
 * @return PDO Database connection instance
 * @throws PDOException If connection fails
 */
function getPDO(): PDO
{
    global $pdo;

    // Return existing connection if available
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        // Build DSN (Data Source Name)
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_NAME,
            DB_CHARSET
        );

        // PDO options for better error handling and security
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch as associative array
            PDO::ATTR_EMULATE_PREPARES   => false,                   // Use real prepared statements
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET, // Set charset
        ];

        // Create PDO instance
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

        return $pdo;

    } catch (PDOException $e) {
        // Handle connection errors gracefully
        if (APP_ENV === 'local' || APP_ENV === 'development') {
            // Show detailed error in development
            die('Database Connection Error: ' . $e->getMessage());
        } else {
            // Log error and show generic message in production
            error_log('Database Connection Error: ' . $e->getMessage());
            die('Database connection failed. Please contact the administrator.');
        }
    }
}

// ============================================================================
// FAQ Helper Functions
// ============================================================================

/**
 * Get all active FAQs by language
 *
 * Retrieves FAQ entries filtered by language and active status,
 * ordered by sort_order (ascending) and created_at (descending).
 *
 * @param string $lang Language code ('ko' or 'en')
 * @return array Array of FAQ records
 */
function getFaqsByLanguage(string $lang): array
{
    try {
        $pdo = getPDO();

        // Validate language parameter
        if (!in_array($lang, ['ko', 'en'])) {
            $lang = DEFAULT_LANG;
        }

        // Prepare SQL query
        $sql = "
            SELECT
                id,
                language,
                category,
                question,
                answer,
                sort_order,
                created_at
            FROM faqs
            WHERE language = :language
              AND is_active = 1
            ORDER BY sort_order ASC, created_at DESC
        ";

        // Execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':language', $lang, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch and return results
        return $stmt->fetchAll();

    } catch (PDOException $e) {
        // Handle query errors gracefully
        if (APP_ENV === 'local' || APP_ENV === 'development') {
            error_log('FAQ Query Error: ' . $e->getMessage());
        }
        return []; // Return empty array on error
    }
}

/**
 * Get FAQs by language and category
 *
 * @param string $lang Language code ('ko' or 'en')
 * @param string $category Category name
 * @return array Array of FAQ records
 */
function getFaqsByCategory(string $lang, string $category): array
{
    try {
        $pdo = getPDO();

        // Validate language parameter
        if (!in_array($lang, ['ko', 'en'])) {
            $lang = DEFAULT_LANG;
        }

        // Prepare SQL query
        $sql = "
            SELECT
                id,
                language,
                category,
                question,
                answer,
                sort_order,
                created_at
            FROM faqs
            WHERE language = :language
              AND category = :category
              AND is_active = 1
            ORDER BY sort_order ASC, created_at DESC
        ";

        // Execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':language', $lang, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch and return results
        return $stmt->fetchAll();

    } catch (PDOException $e) {
        // Handle query errors gracefully
        if (APP_ENV === 'local' || APP_ENV === 'development') {
            error_log('FAQ Category Query Error: ' . $e->getMessage());
        }
        return []; // Return empty array on error
    }
}

// ============================================================================
// Manual Helper Functions
// ============================================================================

/**
 * Get all active Manuals by language
 *
 * Retrieves manual/download entries filtered by language and active status,
 * ordered by sort_order (ascending) and created_at (descending).
 *
 * @param string $lang Language code ('ko' or 'en')
 * @return array Array of manual records
 */
function getManualsByLanguage(string $lang): array
{
    try {
        $pdo = getPDO();

        // Validate language parameter
        if (!in_array($lang, ['ko', 'en'])) {
            $lang = DEFAULT_LANG;
        }

        // Prepare SQL query
        $sql = "
            SELECT
                id,
                language,
                category,
                title,
                description,
                file_path,
                file_size,
                download_count,
                sort_order,
                created_at
            FROM manuals
            WHERE language = :language
              AND is_active = 1
            ORDER BY sort_order ASC, created_at DESC
        ";

        // Execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':language', $lang, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch and return results
        return $stmt->fetchAll();

    } catch (PDOException $e) {
        // Handle query errors gracefully
        if (APP_ENV === 'local' || APP_ENV === 'development') {
            error_log('Manual Query Error: ' . $e->getMessage());
        }
        return []; // Return empty array on error
    }
}

/**
 * Get manuals by language and category
 *
 * @param string $lang Language code ('ko' or 'en')
 * @param string $category Category name
 * @return array Array of manual records
 */
function getManualsByCategory(string $lang, string $category): array
{
    try {
        $pdo = getPDO();

        // Validate language parameter
        if (!in_array($lang, ['ko', 'en'])) {
            $lang = DEFAULT_LANG;
        }

        // Prepare SQL query
        $sql = "
            SELECT
                id,
                language,
                category,
                title,
                description,
                file_path,
                file_size,
                download_count,
                sort_order,
                created_at
            FROM manuals
            WHERE language = :language
              AND category = :category
              AND is_active = 1
            ORDER BY sort_order ASC, created_at DESC
        ";

        // Execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':language', $lang, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch and return results
        return $stmt->fetchAll();

    } catch (PDOException $e) {
        // Handle query errors gracefully
        if (APP_ENV === 'local' || APP_ENV === 'development') {
            error_log('Manual Category Query Error: ' . $e->getMessage());
        }
        return []; // Return empty array on error
    }
}

/**
 * Increment download counter for a manual
 *
 * @param int $manualId Manual ID
 * @return bool Success status
 */
function incrementManualDownloadCount(int $manualId): bool
{
    try {
        $pdo = getPDO();

        $sql = "
            UPDATE manuals
            SET download_count = download_count + 1
            WHERE id = :id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $manualId, PDO::PARAM_INT);

        return $stmt->execute();

    } catch (PDOException $e) {
        // Handle query errors gracefully
        if (APP_ENV === 'local' || APP_ENV === 'development') {
            error_log('Manual Download Count Error: ' . $e->getMessage());
        }
        return false;
    }
}

// ============================================================================
// Utility Functions
// ============================================================================

/**
 * Format file size to human-readable format
 *
 * @param int $bytes File size in bytes
 * @param int $precision Decimal precision
 * @return string Formatted file size
 */
function formatFileSize(int $bytes, int $precision = 2): string
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }

    return round($bytes, $precision) . ' ' . $units[$i];
}

/**
 * Sanitize output for HTML display
 *
 * @param string $text Text to sanitize
 * @return string Sanitized text
 */
function sanitizeOutput(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Format date for display
 *
 * @param string $date Date string
 * @param string $format Date format
 * @return string Formatted date
 */
function formatDate(string $date, string $format = 'Y-m-d'): string
{
    $timestamp = strtotime($date);
    return $timestamp ? date($format, $timestamp) : '';
}

?>
