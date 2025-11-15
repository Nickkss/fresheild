<?php
/**
 * Admin Dashboard
 * Phase 3: Admin Panel
 */

require_once 'includes/auth_check.php';
require_once 'includes/admin_helpers.php';

$pageTitle = '대시보드';

// Get dashboard statistics
$stats = getDashboardStats();

include 'includes/admin_header.php';
include 'includes/admin_nav.php';
?>

<!-- Dashboard Content -->
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">FAQ (한국어)</div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo $stats['faqs_ko']; ?></div>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-question-circle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">FAQ (English)</div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo $stats['faqs_en']; ?></div>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-question-circle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">자료실 (한국어)</div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo $stats['manuals_ko']; ?></div>
                    </div>
                    <div class="text-info">
                        <i class="bi bi-file-earmark-text fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">자료실 (English)</div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo $stats['manuals_en']; ?></div>
                    </div>
                    <div class="text-warning">
                        <i class="bi bi-file-earmark-text fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent FAQs -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>최근 FAQ</span>
                <a href="faq_list.php" class="btn btn-sm btn-outline-primary">전체보기</a>
            </div>
            <div class="card-body">
                <?php if (empty($stats['recent_faqs'])): ?>
                    <p class="text-muted text-center py-4">등록된 FAQ가 없습니다.</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($stats['recent_faqs'] as $faq): ?>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo sanitizeOutput($faq['question']); ?></h6>
                                        <small class="text-muted">
                                            <span class="badge bg-<?php echo $faq['language'] === 'ko' ? 'primary' : 'success'; ?>">
                                                <?php echo $faq['language'] === 'ko' ? '한국어' : 'English'; ?>
                                            </span>
                                            <?php echo date('Y-m-d H:i', strtotime($faq['created_at'])); ?>
                                        </small>
                                    </div>
                                    <a href="faq_edit.php?id=<?php echo $faq['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Manuals -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>최근 자료실</span>
                <a href="manual_list.php" class="btn btn-sm btn-outline-primary">전체보기</a>
            </div>
            <div class="card-body">
                <?php if (empty($stats['recent_manuals'])): ?>
                    <p class="text-muted text-center py-4">등록된 자료가 없습니다.</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($stats['recent_manuals'] as $manual): ?>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?php echo sanitizeOutput($manual['title']); ?></h6>
                                        <small class="text-muted">
                                            <span class="badge bg-<?php echo $manual['language'] === 'ko' ? 'primary' : 'success'; ?>">
                                                <?php echo $manual['language'] === 'ko' ? '한국어' : 'English'; ?>
                                            </span>
                                            <?php echo date('Y-m-d H:i', strtotime($manual['created_at'])); ?>
                                        </small>
                                    </div>
                                    <a href="manual_edit.php?id=<?php echo $manual['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-lightning-charge me-2"></i>빠른 작업
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="faq_edit.php" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle me-2"></i>FAQ 추가
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="manual_edit.php" class="btn btn-outline-success w-100">
                            <i class="bi bi-plus-circle me-2"></i>자료 추가
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="faq_list.php" class="btn btn-outline-info w-100">
                            <i class="bi bi-list-ul me-2"></i>FAQ 목록
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="manual_list.php" class="btn btn-outline-warning w-100">
                            <i class="bi bi-list-ul me-2"></i>자료실 목록
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>
