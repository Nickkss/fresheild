<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

// Get filter parameters
$filterLanguage = $_GET['language'] ?? '';
$filterCategory = $_GET['category'] ?? '';

// Build query
$sql = "SELECT id, language, category, title, file_path, file_size, download_count, is_active, created_at
        FROM manuals WHERE 1=1";
$params = [];

if ($filterLanguage) {
    $sql .= " AND language = :language";
    $params[':language'] = $filterLanguage;
}

if ($filterCategory) {
    $sql .= " AND category = :category";
    $params[':category'] = $filterCategory;
}

$sql .= " ORDER BY sort_order ASC, created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$manuals = $stmt->fetchAll();

// Get all categories for filter
$categoriesStmt = $pdo->query("SELECT DISTINCT category FROM manuals WHERE category IS NOT NULL AND category != '' ORDER BY category");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_COLUMN);

$pageTitle = '자료실 관리';
require_once __DIR__ . '/admin_header.php';
require_once __DIR__ . '/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3"><?php echo sanitizeOutput($pageTitle); ?></h1>
        </div>
        <div class="col-auto">
            <a href="manual_edit.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> 자료 추가
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label for="language" class="form-label">언어</label>
                    <select name="language" id="language" class="form-select">
                        <option value="">전체</option>
                        <option value="ko" <?php echo $filterLanguage === 'ko' ? 'selected' : ''; ?>>한국어</option>
                        <option value="en" <?php echo $filterLanguage === 'en' ? 'selected' : ''; ?>>English</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">카테고리</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">전체</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo sanitizeOutput($category); ?>"
                                    <?php echo $filterCategory === $category ? 'selected' : ''; ?>>
                                <?php echo sanitizeOutput($category); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary me-2">필터 적용</button>
                    <a href="manual_list.php" class="btn btn-outline-secondary">초기화</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Manuals Table -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($manuals)): ?>
                <div class="alert alert-info">등록된 자료가 없습니다.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>언어</th>
                                <th>카테고리</th>
                                <th>제목</th>
                                <th>파일</th>
                                <th>파일 크기</th>
                                <th>다운로드</th>
                                <th>활성화</th>
                                <th>작업</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($manuals as $manual): ?>
                                <tr>
                                    <td><?php echo sanitizeOutput($manual['id']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $manual['language'] === 'ko' ? 'primary' : 'success'; ?>">
                                            <?php echo $manual['language'] === 'ko' ? '한국어' : 'English'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo sanitizeOutput($manual['category'] ?: '-'); ?></td>
                                    <td>
                                        <?php
                                        $title = $manual['title'];
                                        echo sanitizeOutput(mb_strlen($title) > 40 ? mb_substr($title, 0, 40) . '...' : $title);
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($manual['file_path']): ?>
                                            <a href="<?php echo sanitizeOutput($manual['file_path']); ?>"
                                               target="_blank"
                                               class="text-decoration-none">
                                                <i class="bi bi-file-earmark-arrow-down"></i>
                                                <?php echo sanitizeOutput(basename($manual['file_path'])); ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">파일 없음</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $manual['file_size'] ? formatFileSize($manual['file_size']) : '-'; ?></td>
                                    <td>
                                        <span class="badge bg-info">
                                            <?php echo number_format($manual['download_count']); ?>회
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($manual['is_active']): ?>
                                            <span class="badge bg-success">활성</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">비활성</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="manual_edit.php?id=<?php echo $manual['id']; ?>"
                                               class="btn btn-outline-primary">
                                                <i class="bi bi-pencil"></i> 수정
                                            </a>
                                            <a href="manual_delete.php?id=<?php echo $manual['id']; ?>"
                                               class="btn btn-outline-danger">
                                                <i class="bi bi-trash"></i> 삭제
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <p class="text-muted mb-0">총 <?php echo count($manuals); ?>개의 자료</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
