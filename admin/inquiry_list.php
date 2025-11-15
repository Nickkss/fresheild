<?php
/**
 * Inquiry Management - List Page
 * Phase 4: Admin panel for managing customer inquiries
 */

require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/admin_helpers.php';

// Get filter parameters
$filterStatus = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query with filters
$query = "SELECT * FROM inquiries WHERE 1=1";
$params = [];

if ($filterStatus && $filterStatus !== 'all') {
    $query .= " AND status = ?";
    $params[] = $filterStatus;
}

if ($search) {
    $query .= " AND (name LIKE ? OR email LIKE ? OR company LIKE ? OR message LIKE ?)";
    $searchTerm = "%{$search}%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

$query .= " ORDER BY created_at DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalCount = count($inquiries);

    // Get status counts
    $statusCounts = $pdo->query("
        SELECT status, COUNT(*) as count
        FROM inquiries
        GROUP BY status
    ")->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    error_log("Inquiry List Error: " . $e->getMessage());
    $inquiries = [];
    $totalCount = 0;
    $statusCounts = [];
}

$pageTitle = '문의 관리';
include __DIR__ . '/admin_header.php';
include __DIR__ . '/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?php echo sanitizeOutput($pageTitle); ?></h2>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">새 문의</h5>
                    <h2 class="mb-0"><?php echo $statusCounts['new'] ?? 0; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">읽음</h5>
                    <h2 class="mb-0"><?php echo $statusCounts['read'] ?? 0; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">답변 완료</h5>
                    <h2 class="mb-0"><?php echo $statusCounts['replied'] ?? 0; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h5 class="card-title">보관됨</h5>
                    <h2 class="mb-0"><?php echo $statusCounts['archived'] ?? 0; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">상태</label>
                            <select name="status" class="form-select">
                                <option value="all" <?php echo $filterStatus === 'all' || !$filterStatus ? 'selected' : ''; ?>>전체</option>
                                <option value="new" <?php echo $filterStatus === 'new' ? 'selected' : ''; ?>>새 문의</option>
                                <option value="read" <?php echo $filterStatus === 'read' ? 'selected' : ''; ?>>읽음</option>
                                <option value="replied" <?php echo $filterStatus === 'replied' ? 'selected' : ''; ?>>답변 완료</option>
                                <option value="archived" <?php echo $filterStatus === 'archived' ? 'selected' : ''; ?>>보관됨</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">검색</label>
                            <input type="text" name="search" class="form-control" placeholder="이름, 이메일, 회사명, 내용..." value="<?php echo sanitizeOutput($search); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2 d-md-flex">
                                <button type="submit" class="btn btn-primary">필터 적용</button>
                                <a href="inquiry_list.php" class="btn btn-secondary">초기화</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Inquiry List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-3">총 <?php echo $totalCount; ?>건의 문의</p>

                    <?php if (empty($inquiries)): ?>
                        <div class="alert alert-info">
                            문의 내역이 없습니다.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80px;">ID</th>
                                        <th>이름</th>
                                        <th>회사</th>
                                        <th>이메일</th>
                                        <th>관심제품</th>
                                        <th>문의내용</th>
                                        <th style="width: 100px;">상태</th>
                                        <th style="width: 150px;">접수일시</th>
                                        <th style="width: 150px;">작업</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($inquiries as $inquiry): ?>
                                        <tr class="<?php echo $inquiry['status'] === 'new' ? 'table-primary' : ''; ?>">
                                            <td><?php echo sanitizeOutput($inquiry['id']); ?></td>
                                            <td>
                                                <strong><?php echo sanitizeOutput($inquiry['name']); ?></strong>
                                                <?php if ($inquiry['status'] === 'new'): ?>
                                                    <span class="badge bg-danger">New</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo sanitizeOutput($inquiry['company'] ?? '-'); ?></td>
                                            <td><?php echo sanitizeOutput($inquiry['email']); ?></td>
                                            <td><?php echo sanitizeOutput($inquiry['product'] ?? '-'); ?></td>
                                            <td>
                                                <?php
                                                $message = sanitizeOutput($inquiry['message']);
                                                echo mb_substr($message, 0, 50) . (mb_strlen($message) > 50 ? '...' : '');
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusBadge = [
                                                    'new' => '<span class="badge bg-info">새 문의</span>',
                                                    'read' => '<span class="badge bg-warning text-dark">읽음</span>',
                                                    'replied' => '<span class="badge bg-success">답변완료</span>',
                                                    'archived' => '<span class="badge bg-secondary">보관됨</span>'
                                                ];
                                                echo $statusBadge[$inquiry['status']] ?? $inquiry['status'];
                                                ?>
                                            </td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($inquiry['created_at'])); ?></td>
                                            <td>
                                                <a href="inquiry_view.php?id=<?php echo $inquiry['id']; ?>" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i> 보기
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/admin_footer.php'; ?>
