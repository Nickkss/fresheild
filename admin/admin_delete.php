<?php
/**
 * Admin User Management - Delete Handler
 *
 * SUPERADMIN ONLY - Delete admin user with confirmation
 * Phase 3: Admin Panel Security
 */

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/admin_helpers.php';

// SECURITY: Check if user is SUPERADMIN
requireSuperadmin();

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirectWithMessage('admins.php', '유효하지 않은 관리자 ID입니다.', 'error');
    exit;
}

$adminId = (int)$_GET['id'];

// Prevent deleting yourself
if ($adminId === $currentAdmin['id']) {
    redirectWithMessage('admins.php', '현재 로그인한 관리자는 삭제할 수 없습니다.', 'error');
    exit;
}

// Fetch admin details
try {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        SELECT id, username, role, created_at
        FROM admins
        WHERE id = :id
    ");
    $stmt->execute(['id' => $adminId]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        redirectWithMessage('admins.php', '관리자를 찾을 수 없습니다.', 'error');
        exit;
    }
} catch (PDOException $e) {
    error_log("Admin Fetch Error: " . $e->getMessage());
    redirectWithMessage('admins.php', '관리자 로드 중 오류가 발생했습니다.', 'error');
    exit;
}

// Generate nonce for confirmation
$nonce = bin2hex(random_bytes(16));
$_SESSION['delete_nonce'] = $nonce;
$_SESSION['delete_nonce_time'] = time();

// Check if deletion is confirmed
if (isset($_GET['confirm']) && $_GET['confirm'] === '1') {
    // Validate nonce
    if (!isset($_GET['nonce']) ||
        !isset($_SESSION['delete_nonce']) ||
        $_GET['nonce'] !== $_SESSION['delete_nonce'] ||
        !isset($_SESSION['delete_nonce_time']) ||
        (time() - $_SESSION['delete_nonce_time']) > 300) { // 5 minutes expiry

        unset($_SESSION['delete_nonce']);
        unset($_SESSION['delete_nonce_time']);
        redirectWithMessage('admins.php', '유효하지 않거나 만료된 확인 토큰입니다.', 'error');
        exit;
    }

    // Prevent deleting yourself (double check)
    if ($adminId === $currentAdmin['id']) {
        unset($_SESSION['delete_nonce']);
        unset($_SESSION['delete_nonce_time']);
        redirectWithMessage('admins.php', '현재 로그인한 관리자는 삭제할 수 없습니다.', 'error');
        exit;
    }

    // Delete admin
    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("DELETE FROM admins WHERE id = :id");
        $stmt->execute(['id' => $adminId]);

        // Clear nonce
        unset($_SESSION['delete_nonce']);
        unset($_SESSION['delete_nonce_time']);

        redirectWithMessage('admins.php', '관리자가 성공적으로 삭제되었습니다.', 'success');
        exit;
    } catch (PDOException $e) {
        error_log("Admin Delete Error: " . $e->getMessage());
        redirectWithMessage('admins.php', '관리자 삭제 중 오류가 발생했습니다.', 'error');
        exit;
    }
}

$pageTitle = '관리자 삭제';
include __DIR__ . '/includes/admin_header.php';
include __DIR__ . '/includes/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?php echo sanitizeOutput($pageTitle); ?></h2>
                <a href="admins.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> 목록으로
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle"></i> 삭제 확인
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>경고:</strong> 이 작업은 되돌릴 수 없습니다. 관리자를 삭제하시겠습니까?
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">관리자 정보</h6>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 20%;">ID</th>
                                    <td><?php echo sanitizeOutput($admin['id']); ?></td>
                                </tr>
                                <tr>
                                    <th>사용자명</th>
                                    <td><?php echo sanitizeOutput($admin['username']); ?></td>
                                </tr>
                                <tr>
                                    <th>역할</th>
                                    <td>
                                        <?php if ($admin['role'] === 'superadmin'): ?>
                                            <span class="badge badge-superadmin">
                                                <i class="bi bi-star-fill"></i> 슈퍼관리자
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-admin">
                                                <i class="bi bi-person-check"></i> 관리자
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>생성일</th>
                                    <td><?php echo sanitizeOutput($admin['created_at']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="admins.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> 취소
                        </a>
                        <a href="admin_delete.php?id=<?php echo $adminId; ?>&confirm=1&nonce=<?php echo $nonce; ?>"
                           class="btn btn-danger">
                            <i class="bi bi-trash"></i> 삭제 확인
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
