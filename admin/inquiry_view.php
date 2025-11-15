<?php
/**
 * Inquiry Management - View Page
 * Phase 4: View and manage single inquiry
 */

require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

$inquiryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';
$messageType = '';

if (!$inquiryId) {
    header('Location: inquiry_list.php');
    exit;
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $newStatus = $_POST['status'] ?? '';

        if (in_array($newStatus, ['new', 'read', 'replied', 'archived'])) {
            try {
                $stmt = $pdo->prepare("UPDATE inquiries SET status = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$newStatus, $inquiryId]);
                $message = '상태가 업데이트되었습니다.';
                $messageType = 'success';
            } catch (PDOException $e) {
                error_log("Update Status Error: " . $e->getMessage());
                $message = '상태 업데이트 중 오류가 발생했습니다.';
                $messageType = 'danger';
            }
        }
    }
}

// Fetch inquiry details
try {
    $stmt = $pdo->prepare("SELECT * FROM inquiries WHERE id = ?");
    $stmt->execute([$inquiryId]);
    $inquiry = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inquiry) {
        header('Location: inquiry_list.php');
        exit;
    }

    // Mark as read if it's new
    if ($inquiry['status'] === 'new') {
        $updateStmt = $pdo->prepare("UPDATE inquiries SET status = 'read', updated_at = NOW() WHERE id = ?");
        $updateStmt->execute([$inquiryId]);
        $inquiry['status'] = 'read';
    }
} catch (PDOException $e) {
    error_log("Inquiry View Error: " . $e->getMessage());
    header('Location: inquiry_list.php');
    exit;
}

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$pageTitle = '문의 상세보기 #' . $inquiryId;
include __DIR__ . '/admin_header.php';
include __DIR__ . '/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?php echo sanitizeOutput($pageTitle); ?></h2>
                <div>
                    <a href="inquiry_list.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> 목록으로
                    </a>
                    <a href="inquiry_delete.php?id=<?php echo $inquiryId; ?>" class="btn btn-danger" onclick="return confirm('정말 삭제하시겠습니까?');">
                        <i class="bi bi-trash"></i> 삭제
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
            <?php echo sanitizeOutput($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Inquiry Details -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">문의 정보</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>이름:</strong><br>
                            <span class="fs-5"><?php echo sanitizeOutput($inquiry['name']); ?></span>
                        </div>
                        <div class="col-md-6">
                            <strong>회사명:</strong><br>
                            <?php echo sanitizeOutput($inquiry['company'] ?? 'N/A'); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>이메일:</strong><br>
                            <a href="mailto:<?php echo sanitizeOutput($inquiry['email']); ?>">
                                <?php echo sanitizeOutput($inquiry['email']); ?>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <strong>연락처:</strong><br>
                            <?php echo sanitizeOutput($inquiry['phone'] ?? 'N/A'); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>관심 제품:</strong><br>
                            <?php echo sanitizeOutput($inquiry['product'] ?? 'N/A'); ?>
                        </div>
                        <div class="col-md-6">
                            <strong>접수일시:</strong><br>
                            <?php echo date('Y-m-d H:i:s', strtotime($inquiry['created_at'])); ?>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <strong>문의 내용:</strong>
                        <div class="p-3 bg-light border rounded mt-2" style="white-space: pre-wrap;">
<?php echo sanitizeOutput($inquiry['message']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Info -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">기술 정보</h6>
                </div>
                <div class="card-body">
                    <small>
                        <strong>IP Address:</strong> <?php echo sanitizeOutput($inquiry['ip_address'] ?? 'N/A'); ?><br>
                        <strong>User Agent:</strong> <?php echo sanitizeOutput($inquiry['user_agent'] ?? 'N/A'); ?><br>
                        <strong>Last Updated:</strong> <?php echo $inquiry['updated_at'] ? date('Y-m-d H:i:s', strtotime($inquiry['updated_at'])) : 'Never'; ?>
                    </small>
                </div>
            </div>
        </div>

        <!-- Status Management -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">상태 관리</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="update_status" value="1">

                        <div class="mb-3">
                            <label class="form-label"><strong>현재 상태</strong></label>
                            <select name="status" class="form-select form-select-lg">
                                <option value="new" <?php echo $inquiry['status'] === 'new' ? 'selected' : ''; ?>>🔵 새 문의</option>
                                <option value="read" <?php echo $inquiry['status'] === 'read' ? 'selected' : ''; ?>>🟡 읽음</option>
                                <option value="replied" <?php echo $inquiry['status'] === 'replied' ? 'selected' : ''; ?>>🟢 답변 완료</option>
                                <option value="archived" <?php echo $inquiry['status'] === 'archived' ? 'selected' : ''; ?>>⚫ 보관됨</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> 상태 업데이트
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">빠른 작업</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:<?php echo sanitizeOutput($inquiry['email']); ?>?subject=Re: 문의 주셔서 감사합니다&body=<?php echo urlencode($inquiry['name']); ?> 고객님께,%0A%0A문의 주셔서 감사합니다.%0A%0A" class="btn btn-outline-primary">
                            <i class="bi bi-envelope"></i> 이메일 답장
                        </a>

                        <?php if ($inquiry['phone']): ?>
                            <a href="tel:<?php echo sanitizeOutput($inquiry['phone']); ?>" class="btn btn-outline-success">
                                <i class="bi bi-telephone"></i> 전화 걸기
                            </a>
                        <?php endif; ?>

                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="bi bi-printer"></i> 인쇄
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/admin_footer.php'; ?>
