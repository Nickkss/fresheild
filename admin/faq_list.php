<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

// Get filter parameters
$filterLang = isset($_GET['lang']) ? $_GET['lang'] : '';
$filterCategory = isset($_GET['category']) ? $_GET['category'] : '';

// Build query with filters
$query = "SELECT * FROM faqs WHERE 1=1";
$params = [];

if ($filterLang && $filterLang !== 'all') {
    $query .= " AND language = ?";
    $params[] = $filterLang;
}

if ($filterCategory && $filterCategory !== 'all') {
    $query .= " AND category = ?";
    $params[] = $filterCategory;
}

$query .= " ORDER BY sort_order ASC, id DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalCount = count($faqs);

    // Get unique categories for filter dropdown
    $categoryStmt = $pdo->query("SELECT DISTINCT category FROM faqs WHERE category IS NOT NULL AND category != '' ORDER BY category");
    $categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    error_log("FAQ List Error: " . $e->getMessage());
    $faqs = [];
    $totalCount = 0;
    $categories = [];
}

$pageTitle = 'FAQ 관리';
include __DIR__ . '/admin_header.php';
include __DIR__ . '/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?php echo sanitizeOutput($pageTitle); ?></h2>
                <a href="faq_edit.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> FAQ 추가
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="faq_list.php" class="row g-3">
                        <div class="col-md-3">
                            <label for="lang" class="form-label">언어</label>
                            <select name="lang" id="lang" class="form-select">
                                <option value="all" <?php echo $filterLang === 'all' || $filterLang === '' ? 'selected' : ''; ?>>전체</option>
                                <option value="ko" <?php echo $filterLang === 'ko' ? 'selected' : ''; ?>>한국어</option>
                                <option value="en" <?php echo $filterLang === 'en' ? 'selected' : ''; ?>>English</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">카테고리</label>
                            <select name="category" id="category" class="form-select">
                                <option value="all" <?php echo $filterCategory === 'all' || $filterCategory === '' ? 'selected' : ''; ?>>전체</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo sanitizeOutput($cat); ?>" <?php echo $filterCategory === $cat ? 'selected' : ''; ?>>
                                        <?php echo sanitizeOutput($cat); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-secondary me-2">
                                <i class="bi bi-funnel"></i> 필터 적용
                            </button>
                            <a href="faq_list.php" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> 초기화
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">FAQ 목록 (총 <?php echo sanitizeOutput($totalCount); ?>개)</h5>
                </div>
                <div class="card-body">
                    <?php if ($totalCount > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 8%;">언어</th>
                                        <th style="width: 12%;">카테고리</th>
                                        <th style="width: 40%;">질문</th>
                                        <th style="width: 8%;">정렬순서</th>
                                        <th style="width: 10%;">활성상태</th>
                                        <th style="width: 17%;">작업</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($faqs as $faq): ?>
                                        <tr>
                                            <td><?php echo sanitizeOutput($faq['id']); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $faq['language'] === 'ko' ? 'primary' : 'info'; ?>">
                                                    <?php echo sanitizeOutput($faq['language'] === 'ko' ? '한국어' : 'English'); ?>
                                                </span>
                                            </td>
                                            <td><?php echo sanitizeOutput($faq['category'] ?? '-'); ?></td>
                                            <td>
                                                <?php
                                                $question = $faq['question'];
                                                echo sanitizeOutput(mb_strlen($question) > 60 ? mb_substr($question, 0, 60) . '...' : $question);
                                                ?>
                                            </td>
                                            <td><?php echo sanitizeOutput($faq['sort_order']); ?></td>
                                            <td>
                                                <?php if ($faq['is_active']): ?>
                                                    <span class="badge bg-success">활성</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">비활성</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="faq_edit.php?id=<?php echo sanitizeOutput($faq['id']); ?>"
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> 수정
                                                    </a>
                                                    <a href="faq_delete.php?id=<?php echo sanitizeOutput($faq['id']); ?>"
                                                       class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i> 삭제
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> 등록된 FAQ가 없습니다.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/admin_footer.php'; ?>
