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

<!-- Phase 4: Inquiry Statistics -->
<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">새 문의</div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo $stats['inquiries_new']; ?></div>
                        <?php if ($stats['inquiries_new'] > 0): ?>
                            <small class="text-danger"><i class="bi bi-bell-fill"></i> 확인 필요</small>
                        <?php endif; ?>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-envelope-exclamation fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card stat-card secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small mb-1">전체 문의</div>
                        <div class="h4 mb-0 font-weight-bold"><?php echo $stats['inquiries_total']; ?></div>
                    </div>
                    <div class="text-secondary">
                        <i class="bi bi-envelope-fill fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Status Badge -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="alert alert-success d-flex align-items-center" role="alert" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);">
            <div class="me-3">
                <i class="bi bi-check-circle-fill fs-1 text-white"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="alert-heading text-white mb-1">
                    <i class="bi bi-shield-check me-2"></i>System Status: Healthy
                </h5>
                <p class="mb-0 text-white-50 small">
                    <strong>Freshield CMS <?php echo defined('APP_VERSION') ? APP_VERSION : 'v1.0'; ?></strong>
                    | All systems operational | Last checked: <?php echo date('Y-m-d H:i:s'); ?>
                    | Uptime: Excellent
                </p>
            </div>
            <div class="text-end">
                <span class="badge bg-white text-success px-3 py-2" style="font-size: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <i class="bi bi-circle-fill text-success" style="font-size: 8px;"></i> ONLINE
                </span>
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

<!-- Phase 4: Recent Inquiries -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <span><i class="bi bi-envelope me-2"></i>최근 문의</span>
                <a href="inquiry_list.php" class="btn btn-sm btn-light">전체보기</a>
            </div>
            <div class="card-body">
                <?php if (empty($stats['recent_inquiries'])): ?>
                    <p class="text-muted text-center py-4">접수된 문의가 없습니다.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>이름</th>
                                    <th>이메일</th>
                                    <th>제품</th>
                                    <th>메시지</th>
                                    <th>상태</th>
                                    <th>일시</th>
                                    <th>작업</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats['recent_inquiries'] as $inquiry): ?>
                                    <tr class="<?php echo $inquiry['status'] === 'new' ? 'table-primary' : ''; ?>">
                                        <td>
                                            <strong><?php echo sanitizeOutput($inquiry['name']); ?></strong>
                                            <?php if ($inquiry['status'] === 'new'): ?>
                                                <span class="badge bg-danger ms-1">New</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo sanitizeOutput($inquiry['email']); ?></td>
                                        <td><?php echo sanitizeOutput($inquiry['product'] ?? '-'); ?></td>
                                        <td><?php echo sanitizeOutput(mb_substr($inquiry['message'], 0, 30)) . '...'; ?></td>
                                        <td>
                                            <?php
                                            $badges = [
                                                'new' => 'bg-info',
                                                'read' => 'bg-warning',
                                                'replied' => 'bg-success',
                                                'archived' => 'bg-secondary'
                                            ];
                                            $badge = $badges[$inquiry['status']] ?? 'bg-secondary';
                                            ?>
                                            <span class="badge <?php echo $badge; ?>"><?php echo $inquiry['status']; ?></span>
                                        </td>
                                        <td><?php echo date('m/d H:i', strtotime($inquiry['created_at'])); ?></td>
                                        <td>
                                            <a href="inquiry_view.php?id=<?php echo $inquiry['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
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
