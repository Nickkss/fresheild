<?php
/**
 * Inquiry Management - Delete Page
 * Phase 4: Delete inquiry
 */

require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

$inquiryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$inquiryId) {
    $_SESSION['admin_message'] = '잘못된 요청입니다.';
    $_SESSION['admin_message_type'] = 'danger';
    header('Location: inquiry_list.php');
    exit;
}

try {
    // Fetch inquiry details for confirmation
    $stmt = $pdo->prepare("SELECT * FROM inquiries WHERE id = ?");
    $stmt->execute([$inquiryId]);
    $inquiry = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inquiry) {
        $_SESSION['admin_message'] = '문의를 찾을 수 없습니다.';
        $_SESSION['admin_message_type'] = 'danger';
        header('Location: inquiry_list.php');
        exit;
    }

    // Handle deletion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
            if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
                try {
                    $deleteStmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
                    $deleteStmt->execute([$inquiryId]);

                    $_SESSION['admin_message'] = '문의가 성공적으로 삭제되었습니다.';
                    $_SESSION['admin_message_type'] = 'success';
                    header('Location: inquiry_list.php');
                    exit;
                } catch (PDOException $e) {
                    error_log("Delete Inquiry Error: " . $e->getMessage());
                    $_SESSION['admin_message'] = '삭제 중 오류가 발생했습니다.';
                    $_SESSION['admin_message_type'] = 'danger';
                    header('Location: inquiry_list.php');
                    exit;
                }
            } else {
                header('Location: inquiry_view.php?id=' . $inquiryId);
                exit;
            }
        } else {
            $_SESSION['admin_message'] = '잘못된 요청입니다.';
            $_SESSION['admin_message_type'] = 'danger';
            header('Location: inquiry_list.php');
            exit;
        }
    }
} catch (PDOException $e) {
    error_log("Inquiry Delete Error: " . $e->getMessage());
    $_SESSION['admin_message'] = '오류가 발생했습니다.';
    $_SESSION['admin_message_type'] = 'danger';
    header('Location: inquiry_list.php');
    exit;
}

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$pageTitle = '문의 삭제';
include __DIR__ . '/admin_header.php';
include __DIR__ . '/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-exclamation-triangle"></i> 문의 삭제 확인
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <strong>경고!</strong> 이 작업은 되돌릴 수 없습니다. 정말 다음 문의를 삭제하시겠습니까?
                    </div>

                    <div class="p-4 bg-light border rounded">
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>ID:</strong></div>
                            <div class="col-md-8"><?php echo sanitizeOutput($inquiry['id']); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>이름:</strong></div>
                            <div class="col-md-8"><?php echo sanitizeOutput($inquiry['name']); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>회사:</strong></div>
                            <div class="col-md-8"><?php echo sanitizeOutput($inquiry['company'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>이메일:</strong></div>
                            <div class="col-md-8"><?php echo sanitizeOutput($inquiry['email']); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>접수일시:</strong></div>
                            <div class="col-md-8"><?php echo date('Y-m-d H:i:s', strtotime($inquiry['created_at'])); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>문의내용:</strong></div>
                            <div class="col-md-8"><?php echo sanitizeOutput(mb_substr($inquiry['message'], 0, 100)) . '...'; ?></div>
                        </div>
                    </div>

                    <form method="POST" class="mt-4">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="d-flex justify-content-between gap-3">
                            <a href="inquiry_view.php?id=<?php echo $inquiryId; ?>" class="btn btn-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> 취소
                            </a>
                            <button type="submit" name="confirm_delete" value="yes" class="btn btn-danger btn-lg">
                                <i class="bi bi-trash"></i> 삭제 확인
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/admin_footer.php'; ?>
