<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirectWithMessage('faq_list.php', 'Invalid FAQ ID.', 'error');
    exit;
}

$faqId = (int)$_GET['id'];

// Fetch FAQ details
try {
    $stmt = $pdo->prepare("SELECT * FROM faqs WHERE id = ?");
    $stmt->execute([$faqId]);
    $faq = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$faq) {
        redirectWithMessage('faq_list.php', 'FAQ를 찾을 수 없습니다.', 'error');
        exit;
    }
} catch (PDOException $e) {
    error_log("FAQ Fetch Error: " . $e->getMessage());
    redirectWithMessage('faq_list.php', 'FAQ 로드 중 오류가 발생했습니다.', 'error');
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
        redirectWithMessage('faq_list.php', 'Invalid or expired confirmation token.', 'error');
        exit;
    }

    // Delete FAQ
    try {
        $stmt = $pdo->prepare("DELETE FROM faqs WHERE id = ?");
        $stmt->execute([$faqId]);

        // Clear nonce
        unset($_SESSION['delete_nonce']);
        unset($_SESSION['delete_nonce_time']);

        redirectWithMessage('faq_list.php', 'FAQ가 성공적으로 삭제되었습니다.', 'success');
        exit;
    } catch (PDOException $e) {
        error_log("FAQ Delete Error: " . $e->getMessage());
        redirectWithMessage('faq_list.php', 'FAQ 삭제 중 오류가 발생했습니다.', 'error');
        exit;
    }
}

$pageTitle = 'FAQ 삭제';
include __DIR__ . '/admin_header.php';
include __DIR__ . '/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?php echo sanitizeOutput($pageTitle); ?></h2>
                <a href="faq_list.php" class="btn btn-secondary">
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
                        <strong>경고:</strong> 이 작업은 되돌릴 수 없습니다. FAQ를 삭제하시겠습니까?
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-2">FAQ 정보</h6>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 20%;">ID</th>
                                    <td><?php echo sanitizeOutput($faq['id']); ?></td>
                                </tr>
                                <tr>
                                    <th>언어</th>
                                    <td>
                                        <span class="badge bg-<?php echo $faq['language'] === 'ko' ? 'primary' : 'info'; ?>">
                                            <?php echo sanitizeOutput($faq['language'] === 'ko' ? '한국어' : 'English'); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>카테고리</th>
                                    <td><?php echo sanitizeOutput($faq['category'] ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <th>질문</th>
                                    <td><?php echo sanitizeOutput($faq['question']); ?></td>
                                </tr>
                                <tr>
                                    <th>답변</th>
                                    <td>
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            <?php echo nl2br(sanitizeOutput($faq['answer'])); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>정렬순서</th>
                                    <td><?php echo sanitizeOutput($faq['sort_order']); ?></td>
                                </tr>
                                <tr>
                                    <th>활성상태</th>
                                    <td>
                                        <?php if ($faq['is_active']): ?>
                                            <span class="badge bg-success">활성</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">비활성</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>생성일</th>
                                    <td><?php echo sanitizeOutput($faq['created_at']); ?></td>
                                </tr>
                                <tr>
                                    <th>수정일</th>
                                    <td><?php echo sanitizeOutput($faq['updated_at']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="faq_list.php" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> 취소
                        </a>
                        <a href="faq_delete.php?id=<?php echo $faqId; ?>&confirm=1&nonce=<?php echo $nonce; ?>"
                           class="btn btn-danger">
                            <i class="bi bi-trash"></i> 삭제 확인
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/admin_footer.php'; ?>
