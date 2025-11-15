<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

$isEdit = isset($_GET['id']);
$manual = null;
$errors = [];

// If editing, fetch the manual
if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM manuals WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $manual = $stmt->fetch();

    if (!$manual) {
        redirectWithMessage('manual_list.php', '자료를 찾을 수 없습니다.', 'danger');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'CSRF 토큰이 유효하지 않습니다.';
    }

    // Validate required fields
    $language = trim($_POST['language'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    if (empty($language)) {
        $errors[] = '언어를 선택해주세요.';
    }

    if (empty($title)) {
        $errors[] = '제목을 입력해주세요.';
    }

    // Check if file is uploaded
    $hasNewFile = !empty($_FILES['file']['name']);

    // For new manual, file is required
    if (!$isEdit && !$hasNewFile) {
        $errors[] = '파일을 업로드해주세요.';
    }

    // If no errors, process the form
    if (empty($errors)) {
        $filePath = $manual['file_path'] ?? null;
        $fileSize = $manual['file_size'] ?? null;

        // Handle file upload if new file is provided
        if ($hasNewFile) {
            $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            $uploadResult = handleFileUpload($_FILES['file'], 'uploads/manuals/', $allowedExtensions, 10 * 1024 * 1024);

            if ($uploadResult['success']) {
                // Delete old file if editing
                if ($isEdit && $manual['file_path']) {
                    deleteFile($manual['file_path']);
                }

                $filePath = $uploadResult['file_path'];
                $fileSize = $uploadResult['file_size'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }

        // If no errors after file upload, save to database
        if (empty($errors)) {
            try {
                if ($isEdit) {
                    // Update existing manual
                    $sql = "UPDATE manuals SET
                            language = :language,
                            category = :category,
                            title = :title,
                            description = :description,
                            file_path = :file_path,
                            file_size = :file_size,
                            sort_order = :sort_order,
                            is_active = :is_active,
                            updated_at = NOW()
                            WHERE id = :id";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':language' => $language,
                        ':category' => $category ?: null,
                        ':title' => $title,
                        ':description' => $description ?: null,
                        ':file_path' => $filePath,
                        ':file_size' => $fileSize,
                        ':sort_order' => $sortOrder,
                        ':is_active' => $isActive,
                        ':id' => $manual['id']
                    ]);

                    redirectWithMessage('manual_list.php', '자료가 성공적으로 수정되었습니다.', 'success');
                } else {
                    // Insert new manual
                    $sql = "INSERT INTO manuals
                            (language, category, title, description, file_path, file_size, sort_order, is_active, download_count, created_at, updated_at)
                            VALUES
                            (:language, :category, :title, :description, :file_path, :file_size, :sort_order, :is_active, 0, NOW(), NOW())";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':language' => $language,
                        ':category' => $category ?: null,
                        ':title' => $title,
                        ':description' => $description ?: null,
                        ':file_path' => $filePath,
                        ':file_size' => $fileSize,
                        ':sort_order' => $sortOrder,
                        ':is_active' => $isActive
                    ]);

                    redirectWithMessage('manual_list.php', '자료가 성공적으로 추가되었습니다.', 'success');
                }
                exit;
            } catch (PDOException $e) {
                $errors[] = '데이터베이스 오류: ' . $e->getMessage();
            }
        }
    }
}

$pageTitle = $isEdit ? '자료 수정' : '자료 추가';
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

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>오류가 발생했습니다:</strong>
            <ul class="mb-0 mt-2">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo sanitizeOutput($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                        <div class="mb-3">
                            <label for="language" class="form-label">언어 <span class="text-danger">*</span></label>
                            <select name="language" id="language" class="form-select" required>
                                <option value="">선택하세요</option>
                                <option value="ko" <?php echo ($manual['language'] ?? '') === 'ko' ? 'selected' : ''; ?>>한국어</option>
                                <option value="en" <?php echo ($manual['language'] ?? '') === 'en' ? 'selected' : ''; ?>>English</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">카테고리</label>
                            <input type="text"
                                   name="category"
                                   id="category"
                                   class="form-control"
                                   value="<?php echo sanitizeOutput($manual['category'] ?? ''); ?>"
                                   placeholder="예: 제품 매뉴얼, 사용자 가이드">
                            <div class="form-text">자료를 분류할 카테고리를 입력하세요 (선택사항)</div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">제목 <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="form-control"
                                   value="<?php echo sanitizeOutput($manual['title'] ?? ''); ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">설명</label>
                            <textarea name="description"
                                      id="description"
                                      class="form-control"
                                      rows="4"><?php echo sanitizeOutput($manual['description'] ?? ''); ?></textarea>
                            <div class="form-text">자료에 대한 간단한 설명을 입력하세요</div>
                        </div>

                        <?php if ($isEdit && $manual['file_path']): ?>
                            <div class="mb-3">
                                <label class="form-label">현재 파일</label>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-earmark-text fs-1 text-primary me-3"></i>
                                            <div>
                                                <div class="fw-bold">
                                                    <a href="<?php echo sanitizeOutput($manual['file_path']); ?>"
                                                       target="_blank"
                                                       class="text-decoration-none">
                                                        <?php echo sanitizeOutput(basename($manual['file_path'])); ?>
                                                    </a>
                                                </div>
                                                <div class="text-muted small">
                                                    파일 크기: <?php echo formatFileSize($manual['file_size']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="file" class="form-label">
                                파일 업로드
                                <?php if (!$isEdit): ?>
                                    <span class="text-danger">*</span>
                                <?php else: ?>
                                    <span class="text-muted">(변경하려면 새 파일 선택)</span>
                                <?php endif; ?>
                            </label>
                            <input type="file"
                                   name="file"
                                   id="file"
                                   class="form-control"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                   <?php echo !$isEdit ? 'required' : ''; ?>>
                            <div class="form-text">
                                허용 파일 형식: PDF, DOC, DOCX, JPG, PNG (최대 10MB)
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">정렬 순서</label>
                            <input type="number"
                                   name="sort_order"
                                   id="sort_order"
                                   class="form-control"
                                   value="<?php echo sanitizeOutput($manual['sort_order'] ?? 0); ?>"
                                   min="0">
                            <div class="form-text">숫자가 작을수록 먼저 표시됩니다</div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox"
                                       name="is_active"
                                       id="is_active"
                                       class="form-check-input"
                                       value="1"
                                       <?php echo ($manual['is_active'] ?? 1) ? 'checked' : ''; ?>>
                                <label for="is_active" class="form-check-label">활성화</label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="manual_list.php" class="btn btn-secondary">취소</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> <?php echo $isEdit ? '수정' : '추가'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">도움말</h5>
                </div>
                <div class="card-body">
                    <h6>파일 업로드 가이드</h6>
                    <ul class="small">
                        <li>지원 형식: PDF, DOC, DOCX, JPG, PNG</li>
                        <li>최대 파일 크기: 10MB</li>
                        <li>파일명은 영문과 숫자를 권장합니다</li>
                    </ul>

                    <h6 class="mt-3">카테고리 예시</h6>
                    <ul class="small">
                        <li>제품 매뉴얼</li>
                        <li>사용자 가이드</li>
                        <li>설치 가이드</li>
                        <li>기술 문서</li>
                        <li>브로슈어</li>
                    </ul>

                    <?php if ($isEdit): ?>
                        <h6 class="mt-3">통계</h6>
                        <ul class="small">
                            <li>다운로드 수: <?php echo number_format($manual['download_count']); ?>회</li>
                            <li>등록일: <?php echo date('Y-m-d H:i', strtotime($manual['created_at'])); ?></li>
                            <?php if ($manual['updated_at']): ?>
                                <li>수정일: <?php echo date('Y-m-d H:i', strtotime($manual['updated_at'])); ?></li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
