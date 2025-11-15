<?php
/**
 * Admin Helper Functions
 * Security utilities, file upload, flash messages, etc.
 *
 * Phase 3: Admin Panel
 */

// Include database connection
require_once __DIR__ . '/../../public/includes/db.php';

// ============================================================================
// CSRF Protection
// ============================================================================

/**
 * Generate CSRF token for forms
 * @return string CSRF token
 */
function csrf_generate_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token from form submission
 * @param string $token Token to validate
 * @return bool True if valid
 */
function csrf_validate_token(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Output CSRF token hidden input field
 * @return void
 */
function csrf_field(): void
{
    $token = csrf_generate_token();
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

// ============================================================================
// Flash Messages
// ============================================================================

/**
 * Set flash message in session
 * @param string $type Type of message (success, error, warning, info)
 * @param string $message Message text
 * @return void
 */
function setFlashMessage(string $type, string $message): void
{
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get and clear flash message from session
 * @return array|null Flash message array or null
 */
function getFlashMessage(): ?array
{
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

/**
 * Display flash message HTML
 * @return void
 */
function displayFlashMessage(): void
{
    $flash = getFlashMessage();
    if ($flash) {
        $alertClass = [
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info'
        ][$flash['type']] ?? 'alert-info';

        echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($flash['message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
    }
}

// ============================================================================
// Redirect Helpers
// ============================================================================

/**
 * Redirect to URL with optional flash message
 * @param string $url URL to redirect to
 * @param string|null $message Flash message
 * @param string $type Flash message type
 * @return never
 */
function redirectWithMessage(string $url, ?string $message = null, string $type = 'success'): never
{
    if ($message) {
        setFlashMessage($type, $message);
    }
    header('Location: ' . $url);
    exit;
}

// ============================================================================
// Validation Helpers
// ============================================================================

/**
 * Validate required fields in array
 * @param array $data Data to validate
 * @param array $required Required field names
 * @return array Empty if valid, error messages if invalid
 */
function validateRequiredFields(array $data, array $required): array
{
    $errors = [];
    foreach ($required as $field) {
        if (empty($data[$field]) && $data[$field] !== '0') {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
        }
    }
    return $errors;
}

// ============================================================================
// File Upload Helpers
// ============================================================================

/**
 * Handle file upload for manuals
 * @param array $file $_FILES array element
 * @param string $uploadDir Upload directory path
 * @param array $allowedTypes Allowed MIME types
 * @param int $maxSize Max file size in bytes
 * @return array ['success' => bool, 'path' => string, 'error' => string]
 */
function handleFileUpload(
    array $file,
    string $uploadDir = '/admin/uploads/manuals/',
    array $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    int $maxSize = 10485760 // 10MB
): array
{
    // Check if file was uploaded
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'path' => '', 'error' => 'No file uploaded'];
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'path' => '', 'error' => 'Upload error: ' . $file['error']];
    }

    // Check file size
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'path' => '', 'error' => 'File too large (max ' . formatFileSize($maxSize) . ')'];
    }

    // Check file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'path' => '', 'error' => 'Invalid file type'];
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;

    // Full path
    $fullPath = BASE_PATH . $uploadDir . $filename;
    $relativePath = $uploadDir . $filename;

    // Ensure directory exists
    $dir = dirname($fullPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $fullPath)) {
        return [
            'success' => true,
            'path' => $relativePath,
            'filename' => $filename,
            'size' => $file['size'],
            'error' => ''
        ];
    }

    return ['success' => false, 'path' => '', 'error' => 'Failed to move uploaded file'];
}

/**
 * Delete file from filesystem
 * @param string $filePath Relative or absolute file path
 * @return bool Success status
 */
function deleteFile(string $filePath): bool
{
    // Convert to absolute path if relative
    if (strpos($filePath, BASE_PATH) !== 0) {
        $filePath = BASE_PATH . $filePath;
    }

    if (file_exists($filePath) && is_file($filePath)) {
        return unlink($filePath);
    }

    return false;
}

// ============================================================================
// Admin Database Helpers
// ============================================================================

/**
 * Get admin user by ID
 * @param int $adminId Admin ID
 * @return array|null Admin data or null
 */
function getAdminById(int $adminId): ?array
{
    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT id, username, role, created_at
            FROM admins
            WHERE id = :id
        ");
        $stmt->execute(['id' => $adminId]);
        $admin = $stmt->fetch();
        return $admin ?: null;
    } catch (PDOException $e) {
        error_log('Get admin error: ' . $e->getMessage());
        return null;
    }
}

/**
 * Get admin user by username
 * @param string $username Username
 * @return array|null Admin data or null
 */
function getAdminByUsername(string $username): ?array
{
    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT id, username, password_hash, role, created_at
            FROM admins
            WHERE username = :username
        ");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();
        return $admin ?: null;
    } catch (PDOException $e) {
        error_log('Get admin by username error: ' . $e->getMessage());
        return null;
    }
}

/**
 * Verify admin credentials
 * @param string $username Username
 * @param string $password Plain text password
 * @return array|false Admin data if valid, false if invalid
 */
function verifyAdminCredentials(string $username, string $password)
{
    $admin = getAdminByUsername($username);

    if ($admin && password_verify($password, $admin['password_hash'])) {
        // Remove password hash from returned data
        unset($admin['password_hash']);
        return $admin;
    }

    return false;
}

/**
 * Create default admin user if none exists
 * @return bool Success status
 */
function createDefaultAdmin(): bool
{
    try {
        $pdo = getPDO();

        // Check if any admin exists
        $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // Create default superadmin
            $stmt = $pdo->prepare("
                INSERT INTO admins (username, password_hash, role)
                VALUES (:username, :password_hash, :role)
            ");

            $stmt->execute([
                'username' => 'admin',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'superadmin'
            ]);

            return true;
        }

        return false;
    } catch (PDOException $e) {
        error_log('Create default admin error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Get all admins
 * @return array Array of admin records
 */
function getAllAdmins(): array
{
    try {
        $pdo = getPDO();
        $stmt = $pdo->query("
            SELECT id, username, role, created_at
            FROM admins
            ORDER BY created_at DESC
        ");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Get all admins error: ' . $e->getMessage());
        return [];
    }
}

// ============================================================================
// Dashboard Statistics
// ============================================================================

/**
 * Get dashboard statistics
 * @return array Statistics array
 */
function getDashboardStats(): array
{
    try {
        $pdo = getPDO();

        // FAQ counts
        $stmt = $pdo->query("SELECT COUNT(*) FROM faqs WHERE language='ko' AND is_active=1");
        $faqsKo = $stmt->fetchColumn();

        $stmt = $pdo->query("SELECT COUNT(*) FROM faqs WHERE language='en' AND is_active=1");
        $faqsEn = $stmt->fetchColumn();

        // Manual counts
        $stmt = $pdo->query("SELECT COUNT(*) FROM manuals WHERE language='ko' AND is_active=1");
        $manualsKo = $stmt->fetchColumn();

        $stmt = $pdo->query("SELECT COUNT(*) FROM manuals WHERE language='en' AND is_active=1");
        $manualsEn = $stmt->fetchColumn();

        // Admin count
        $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
        $admins = $stmt->fetchColumn();

        // Recent FAQs
        $stmt = $pdo->query("
            SELECT id, language, question, created_at
            FROM faqs
            ORDER BY created_at DESC
            LIMIT 5
        ");
        $recentFaqs = $stmt->fetchAll();

        // Recent Manuals
        $stmt = $pdo->query("
            SELECT id, language, title, created_at
            FROM manuals
            ORDER BY created_at DESC
            LIMIT 5
        ");
        $recentManuals = $stmt->fetchAll();

        return [
            'faqs_ko' => $faqsKo,
            'faqs_en' => $faqsEn,
            'manuals_ko' => $manualsKo,
            'manuals_en' => $manualsEn,
            'admins' => $admins,
            'recent_faqs' => $recentFaqs,
            'recent_manuals' => $recentManuals
        ];
    } catch (PDOException $e) {
        error_log('Dashboard stats error: ' . $e->getMessage());
        return [
            'faqs_ko' => 0,
            'faqs_en' => 0,
            'manuals_ko' => 0,
            'manuals_en' => 0,
            'admins' => 0,
            'recent_faqs' => [],
            'recent_manuals' => []
        ];
    }
}

// ============================================================================
// PHASE 4: Admin Login Security & Activity Logging
// ============================================================================

/**
 * Log admin login attempt
 * @param int|null $adminId Admin ID (null if failed)
 * @param string $username Username attempted
 * @param string $status 'success', 'failed', or 'blocked'
 * @param string|null $failureReason Reason for failure
 * @return bool Success status
 */
function logAdminLogin(?int $adminId, string $username, string $status, ?string $failureReason = null): bool
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            INSERT INTO admin_logins
            (admin_id, username, ip_address, user_agent, status, failure_reason)
            VALUES (:admin_id, :username, :ip_address, :user_agent, :status, :failure_reason)
        ");

        return $stmt->execute([
            'admin_id' => $adminId,
            'username' => $username,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'status' => $status,
            'failure_reason' => $failureReason
        ]);
    } catch (PDOException $e) {
        error_log('Login logging error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Get recent login attempts for admin panel
 * @param int $limit Number of records to fetch
 * @return array Login attempts
 */
function getRecentLoginAttempts(int $limit = 50): array
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            SELECT
                al.id,
                al.admin_id,
                al.username,
                al.ip_address,
                al.status,
                al.failure_reason,
                al.created_at,
                a.username as admin_username
            FROM admin_logins al
            LEFT JOIN admins a ON al.admin_id = a.id
            ORDER BY al.created_at DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Get login attempts error: ' . $e->getMessage());
        return [];
    }
}

/**
 * Get failed login attempts by IP address within time window
 * @param string $ipAddress IP address to check
 * @param int $minutes Time window in minutes
 * @return int Number of failed attempts
 */
function getFailedLoginsByIP(string $ipAddress, int $minutes = 5): int
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM admin_logins
            WHERE ip_address = :ip_address
            AND status = 'failed'
            AND created_at > DATE_SUB(NOW(), INTERVAL :minutes MINUTE)
        ");

        $stmt->execute([
            'ip_address' => $ipAddress,
            'minutes' => $minutes
        ]);

        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('Get failed logins error: ' . $e->getMessage());
        return 0;
    }
}

/**
 * Check if IP address is blocked due to too many failed attempts
 * @param string $ipAddress IP address to check
 * @return array ['blocked' => bool, 'attempts' => int, 'wait_minutes' => int]
 */
function checkLoginRateLimit(string $ipAddress): array
{
    $failedAttempts = getFailedLoginsByIP($ipAddress, 5);

    // 3 failed attempts in 5 minutes = 5 minute lockout
    if ($failedAttempts >= 3 && $failedAttempts < 10) {
        return [
            'blocked' => true,
            'attempts' => $failedAttempts,
            'wait_minutes' => 5
        ];
    }

    // 10 failed attempts in 5 minutes = 60 minute lockout
    if ($failedAttempts >= 10) {
        return [
            'blocked' => true,
            'attempts' => $failedAttempts,
            'wait_minutes' => 60
        ];
    }

    return [
        'blocked' => false,
        'attempts' => $failedAttempts,
        'wait_minutes' => 0
    ];
}

/**
 * Update admin last login information
 * @param int $adminId Admin ID
 * @return bool Success status
 */
function updateAdminLastLogin(int $adminId): bool
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            UPDATE admins
            SET last_login_at = NOW(),
                last_login_ip = :ip_address,
                failed_login_count = 0
            WHERE id = :admin_id
        ");

        return $stmt->execute([
            'admin_id' => $adminId,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
    } catch (PDOException $e) {
        error_log('Update last login error: ' . $e->getMessage());
        return false;
    }
}

// ============================================================================
// PHASE 4: Inquiry Management Functions
// ============================================================================

/**
 * Get all inquiries with optional filtering
 * @param string $status Filter by status ('all', 'new', 'read', 'replied', 'archived')
 * @param int $limit Number of records to fetch
 * @param int $offset Offset for pagination
 * @return array Inquiries
 */
function getInquiries(string $status = 'all', int $limit = 50, int $offset = 0): array
{
    try {
        $pdo = getPDO();

        $sql = "SELECT * FROM inquiries";

        if ($status !== 'all') {
            $sql .= " WHERE status = :status";
        }

        $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);

        if ($status !== 'all') {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Get inquiries error: ' . $e->getMessage());
        return [];
    }
}

/**
 * Get single inquiry by ID
 * @param int $id Inquiry ID
 * @return array|null Inquiry data or null
 */
function getInquiryById(int $id): ?array
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("SELECT * FROM inquiries WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $inquiry = $stmt->fetch();
        return $inquiry ?: null;
    } catch (PDOException $e) {
        error_log('Get inquiry error: ' . $e->getMessage());
        return null;
    }
}

/**
 * Update inquiry status
 * @param int $id Inquiry ID
 * @param string $status New status
 * @return bool Success status
 */
function updateInquiryStatus(int $id, string $status): bool
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            UPDATE inquiries
            SET status = :status
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
    } catch (PDOException $e) {
        error_log('Update inquiry status error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Delete inquiry
 * @param int $id Inquiry ID
 * @return bool Success status
 */
function deleteInquiry(int $id): bool
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        error_log('Delete inquiry error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Get count of new inquiries
 * @param int $days Number of days to look back
 * @return int Count of new inquiries
 */
function getNewInquiriesCount(int $days = 7): int
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM inquiries
            WHERE status = 'new'
            AND created_at > DATE_SUB(NOW(), INTERVAL :days DAY)
        ");

        $stmt->execute(['days' => $days]);
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log('Get new inquiries count error: ' . $e->getMessage());
        return 0;
    }
}

// ============================================================================
// PHASE 4: Notice Management Functions
// ============================================================================

/**
 * Get all notices by language
 * @param string $language Language code ('ko' or 'en')
 * @param bool $activeOnly Get only active notices
 * @return array Notices
 */
function getNoticesByLanguage(string $language, bool $activeOnly = true): array
{
    try {
        $pdo = getPDO();

        $sql = "SELECT * FROM notices WHERE language = :language";

        if ($activeOnly) {
            $sql .= " AND is_active = 1";
        }

        $sql .= " ORDER BY sort_order ASC, created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['language' => $language]);

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('Get notices error: ' . $e->getMessage());
        return [];
    }
}

/**
 * Get single notice by ID
 * @param int $id Notice ID
 * @return array|null Notice data or null
 */
function getNoticeById(int $id): ?array
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("SELECT * FROM notices WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $notice = $stmt->fetch();
        return $notice ?: null;
    } catch (PDOException $e) {
        error_log('Get notice error: ' . $e->getMessage());
        return null;
    }
}

/**
 * Increment notice view count
 * @param int $id Notice ID
 * @return bool Success status
 */
function incrementNoticeViewCount(int $id): bool
{
    try {
        $pdo = getPDO();

        $stmt = $pdo->prepare("
            UPDATE notices
            SET view_count = view_count + 1
            WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        error_log('Increment notice view count error: ' . $e->getMessage());
        return false;
    }
}

?>

