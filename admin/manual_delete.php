<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    redirectWithMessage('manual_list.php', '자료 ID가 제공되지 않았습니다.', 'danger');
    exit;
}

$manualId = (int)$_GET['id'];

// Fetch the manual
$stmt = $pdo->prepare("SELECT * FROM manuals WHERE id = :id");
$stmt->execute([':id' => $manualId]);
$manual = $stmt->fetch();

if (!$manual) {
    redirectWithMessage('manual_list.php', '자료를 찾을 수 없습니다.', 'danger');
    exit;
}

// Handle deletion confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        redirectWithMessage('manual_list.php', 'CSRF 토큰이 유효하지 않습니다.', 'danger');
        exit;
    }

    try {
        // Delete the file from filesystem
        if ($manual['file_path']) {
            deleteFile($manual['file_path']);
        }

        // Delete from database
        $stmt = $pdo->prepare("DELETE FROM manuals WHERE id = :id");
        $stmt->execute([':id' => $manualId]);

        redirectWithMessage('manual_list.php', '자료가 성공적으로 삭제되었습니다.', 'success');
        exit;
    } catch (PDOException $e) {
        redirectWithMessage('manual_list.php', '삭제 중 오류가 발생했습니다: ' . $e->getMessage(), 'danger');
        exit;
    }
}

$pageTitle = '자료 삭제';
require_once __DIR__ . '/admin_header.php';
require_once __DIR__ . '/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3"><?php echo sanitizeOutput($pageTitle); ?></h1>
        </div>
        <div class="col-auto">
            <a href="manual_list.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> 목록으로
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle"></i> 삭제 확인
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>경고:</strong> 이 작업은 되돌릴 수 없습니다. 자료와 파일이 영구적으로 삭제됩니다.
                    </div>

                    <h6 class="mb-3">다음 자료를 삭제하시겠습니까?</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 200px;">ID</th>
                                    <td><?php echo sanitizeOutput($manual['id']); ?></td>
                                </tr>
                                <tr>
                                    <th>언어</th>
                                    <td>
                                        <span class="badge bg-<?php echo $manual['language'] === 'ko' ? 'primary' : 'success'; ?>">
                                            <?php echo $manual['language'] === 'ko' ? '한국어' : 'English'; ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>카테고리</th>
                                    <td><?php echo sanitizeOutput($manual['category'] ?: '-'); ?></td>
                                </tr>
                                <tr>
                                    <th>제목</th>
                                    <td><?php echo sanitizeOutput($manual['title']); ?></td>
                                </tr>
                                <tr>
                                    <th>설명</th>
                                    <td><?php echo sanitizeOutput($manual['description'] ?: '-'); ?></td>
                                </tr>
                                <tr>
                                    <th>파일</th>
                                    <td>
                                        <?php if ($manual['file_path']): ?>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-earmark-text fs-4 text-primary me-2"></i>
                                                <div>
                                                    <div>
                                                        <a href="<?php echo sanitizeOutput($manual['file_path']); ?>"
                                                           target="_blank"
                                                           class="text-decoration-none">
                                                            <?php echo sanitizeOutput(basename($manual['file_path'])); ?>
                                                        </a>
                                                    </div>
                                                    <div class="text-muted small">
                                                        크기: <?php echo formatFileSize($manual['file_size']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">파일 없음</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>다운로드 수</th>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo number_format($manual['download_count']); ?>회
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>정렬 순서</th>
                                    <td><?php echo sanitizeOutput($manual['sort_order']); ?></td>
                                </tr>
                                <tr>
                                    <th>활성화 상태</th>
                                    <td>
                                        <?php if ($manual['is_active']): ?>
                                            <span class="badge bg-success">활성</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">비활성</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>등록일</th>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($manual['created_at'])); ?></td>
                                </tr>
                                <?php if ($manual['updated_at']): ?>
                                    <tr>
                                        <th>수정일</th>
                                        <td><?php echo date('Y-m-d H:i:s', strtotime($manual['updated_at'])); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <form method="post" class="mt-4">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="manual_list.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> 취소
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> 삭제 확인
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">삭제 시 영향</h6>
                    <ul class="mb-0">
                        <li>데이터베이스에서 자료 정보가 영구 삭제됩니다</li>
                        <li>서버에 저장된 파일이 삭제됩니다</li>
                        <li>사용자는 더 이상 이 자료를 다운로드할 수 없습니다</li>
                        <li>다운로드 통계 정보도 함께 삭제됩니다</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
