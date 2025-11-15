<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

// Determine if we're editing or creating
$isEdit = isset($_GET['id']) && is_numeric($_GET['id']);
$faqId = $isEdit ? (int)$_GET['id'] : null;
$faq = null;

// If editing, fetch existing FAQ
if ($isEdit) {
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
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        redirectWithMessage('faq_list.php', 'Invalid CSRF token.', 'error');
        exit;
    }

    // Get and validate form data
    $language = isset($_POST['language']) ? trim($_POST['language']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : null;
    $question = isset($_POST['question']) ? trim($_POST['question']) : '';
    $answer = isset($_POST['answer']) ? trim($_POST['answer']) : '';
    $sortOrder = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    // Validation
    $errors = [];

    if (empty($language) || !in_array($language, ['ko', 'en'])) {
        $errors[] = '언어를 선택해주세요.';
    }

    if (empty($question)) {
        $errors[] = '질문을 입력해주세요.';
    }

    if (empty($answer)) {
        $errors[] = '답변을 입력해주세요.';
    }

    if (empty($errors)) {
        try {
            if ($isEdit) {
                // Update existing FAQ
                $stmt = $pdo->prepare("
                    UPDATE faqs
                    SET language = ?, category = ?, question = ?, answer = ?,
                        sort_order = ?, is_active = ?, updated_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$language, $category, $question, $answer, $sortOrder, $isActive, $faqId]);
                redirectWithMessage('faq_list.php', 'FAQ가 성공적으로 수정되었습니다.', 'success');
            } else {
                // Insert new FAQ
                $stmt = $pdo->prepare("
                    INSERT INTO faqs (language, category, question, answer, sort_order, is_active, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
                ");
                $stmt->execute([$language, $category, $question, $answer, $sortOrder, $isActive]);
                redirectWithMessage('faq_list.php', 'FAQ가 성공적으로 추가되었습니다.', 'success');
            }
            exit;
        } catch (PDOException $e) {
            error_log("FAQ Save Error: " . $e->getMessage());
            $errors[] = 'FAQ 저장 중 오류가 발생했습니다.';
        }
    }
}

$pageTitle = $isEdit ? 'FAQ 수정' : 'FAQ 추가';
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
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo sanitizeOutput($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo $isEdit ? 'faq_edit.php?id=' . $faqId : 'faq_edit.php'; ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="language" class="form-label">
                                언어 <span class="text-danger">*</span>
                            </label>
                            <select name="language" id="language" class="form-select" required>
                                <option value="">선택하세요</option>
                                <option value="ko" <?php echo ($faq && $faq['language'] === 'ko') || (!$faq && isset($_POST['language']) && $_POST['language'] === 'ko') ? 'selected' : ''; ?>>
                                    한국어
                                </option>
                                <option value="en" <?php echo ($faq && $faq['language'] === 'en') || (!$faq && isset($_POST['language']) && $_POST['language'] === 'en') ? 'selected' : ''; ?>>
                                    English
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">카테고리</label>
                            <input type="text"
                                   name="category"
                                   id="category"
                                   class="form-control"
                                   value="<?php echo sanitizeOutput($faq['category'] ?? $_POST['category'] ?? ''); ?>"
                                   placeholder="예: 일반, 결제, 배송 등">
                            <small class="form-text text-muted">선택 사항입니다.</small>
                        </div>

                        <div class="mb-3">
                            <label for="question" class="form-label">
                                질문 <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="question"
                                   id="question"
                                   class="form-control"
                                   value="<?php echo sanitizeOutput($faq['question'] ?? $_POST['question'] ?? ''); ?>"
                                   required
                                   placeholder="FAQ 질문을 입력하세요">
                        </div>

                        <div class="mb-3">
                            <label for="answer" class="form-label">
                                답변 <span class="text-danger">*</span>
                            </label>
                            <textarea name="answer"
                                      id="answer"
                                      class="form-control"
                                      rows="10"
                                      required
                                      placeholder="FAQ 답변을 입력하세요"><?php echo sanitizeOutput($faq['answer'] ?? $_POST['answer'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">정렬 순서</label>
                            <input type="number"
                                   name="sort_order"
                                   id="sort_order"
                                   class="form-control"
                                   value="<?php echo sanitizeOutput($faq['sort_order'] ?? $_POST['sort_order'] ?? 0); ?>"
                                   min="0"
                                   step="1">
                            <small class="form-text text-muted">낮은 숫자가 먼저 표시됩니다.</small>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox"
                                       name="is_active"
                                       id="is_active"
                                       class="form-check-input"
                                       value="1"
                                       <?php echo ($faq && $faq['is_active']) || (!$faq && !isset($_POST['is_active'])) || (isset($_POST['is_active'])) ? 'checked' : ''; ?>>
                                <label for="is_active" class="form-check-label">
                                    활성화
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="faq_list.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> 취소
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> <?php echo $isEdit ? '수정' : '추가'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/admin_footer.php'; ?>
