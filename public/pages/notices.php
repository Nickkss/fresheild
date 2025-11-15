<?php
/**
 * Notice Board - Korean Version
 * Phase 4: Notice/News listing
 */

$lang = 'ko';
$is_english = false;

$pageTitle = '공지사항 - 후레쉴드';
$pageDescription = '후레쉴드의 새로운 소식과 공지사항을 확인하세요.';

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header_optimized.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Fetch Korean notices
try {
    $pdo = db_connect();

    // Get total count
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM notices WHERE language = 'ko' AND is_active = 1");
    $stmt->execute();
    $totalNotices = $stmt->fetchColumn();

    // Get notices for current page
    $stmt = $pdo->prepare("
        SELECT * FROM notices
        WHERE language = 'ko' AND is_active = 1
        ORDER BY sort_order ASC, created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $notices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPages = ceil($totalNotices / $perPage);
} catch (PDOException $e) {
    error_log("Notices fetch error: " . $e->getMessage());
    $notices = [];
    $totalPages = 0;
}
?>

<style>
.notices-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
}

.notices-header {
    text-align: center;
    margin-bottom: 40px;
}

.notices-header h1 {
    font-size: 36px;
    color: #2c3e50;
    margin-bottom: 10px;
}

.notices-header p {
    color: #666;
    font-size: 16px;
}

.notice-list {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.notice-item {
    border-bottom: 1px solid #e0e0e0;
    padding: 20px 25px;
    transition: background 0.3s;
    cursor: pointer;
}

.notice-item:last-child {
    border-bottom: none;
}

.notice-item:hover {
    background: #f8f9fa;
}

.notice-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.notice-title a {
    color: #333;
    text-decoration: none;
}

.notice-title a:hover {
    color: #3498db;
}

.notice-meta {
    font-size: 14px;
    color: #999;
}

.notice-meta span {
    margin-right: 15px;
}

.notice-badge {
    display: inline-block;
    background: #e74c3c;
    color: white;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    margin-left: 10px;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}

.pagination a, .pagination span {
    padding: 8px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
}

.pagination a:hover {
    background: #3498db;
    color: white;
    border-color: #3498db;
}

.pagination .current {
    background: #3498db;
    color: white;
    border-color: #3498db;
}

.empty-notices {
    text-align: center;
    padding: 60px 20px;
    color: #999;
}

.empty-notices i {
    font-size: 64px;
    margin-bottom: 20px;
    display: block;
}
</style>

<div class="notices-container">
    <div class="notices-header">
        <h1>📢 공지사항</h1>
        <p>후레쉴드의 새로운 소식과 중요한 공지사항을 확인하세요</p>
    </div>

    <?php if (empty($notices)): ?>
        <div class="notice-list">
            <div class="empty-notices">
                <i>📭</i>
                <p>등록된 공지사항이 없습니다.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="notice-list">
            <?php foreach ($notices as $index => $notice): ?>
                <?php
                // Check if notice is within 7 days (mark as NEW)
                $isNew = (time() - strtotime($notice['created_at'])) < (7 * 24 * 60 * 60);
                ?>
                <div class="notice-item" onclick="location.href='notice_view.php?id=<?php echo $notice['id']; ?>'">
                    <div class="notice-title">
                        <a href="notice_view.php?id=<?php echo $notice['id']; ?>">
                            <?php echo htmlspecialchars($notice['title']); ?>
                        </a>
                        <?php if ($isNew): ?>
                            <span class="notice-badge">NEW</span>
                        <?php endif; ?>
                    </div>
                    <div class="notice-meta">
                        <span>📅 <?php echo date('Y-m-d', strtotime($notice['created_at'])); ?></span>
                        <span>👁️ 조회 <?php echo number_format($notice['view_count']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">« 이전</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span class="current"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">다음 »</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
