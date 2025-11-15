<?php
/**
 * Admin User Management - List Page
 *
 * SUPERADMIN ONLY - Lists all admin users with options to edit/delete
 * Phase 3: Admin Panel Security
 */

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/admin_helpers.php';

// SECURITY: Check if user is SUPERADMIN
requireSuperadmin();

// Get all admins from database
$admins = getAllAdmins();
$totalCount = count($admins);

$pageTitle = '관리자 관리';
include __DIR__ . '/includes/admin_header.php';
include __DIR__ . '/includes/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?php echo sanitizeOutput($pageTitle); ?></h2>
                <a href="admin_edit.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> 관리자 추가
                </a>
            </div>
        </div>
    </div>

    <!-- Admin List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">관리자 목록 (총 <?php echo sanitizeOutput($totalCount); ?>명)</h5>
                </div>
                <div class="card-body">
                    <?php displayFlashMessage(); ?>

                    <?php if ($totalCount > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 8%;">ID</th>
                                        <th style="width: 30%;">사용자명</th>
                                        <th style="width: 20%;">역할</th>
                                        <th style="width: 25%;">생성일</th>
                                        <th style="width: 17%;">작업</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($admins as $admin): ?>
                                        <tr>
                                            <td><?php echo sanitizeOutput($admin['id']); ?></td>
                                            <td><?php echo sanitizeOutput($admin['username']); ?></td>
                                            <td>
                                                <?php if ($admin['role'] === 'superadmin'): ?>
                                                    <span class="badge badge-superadmin">
                                                        <i class="bi bi-star-fill"></i> 슈퍼관리자
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-admin">
                                                        <i class="bi bi-person-check"></i> 관리자
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo sanitizeOutput($admin['created_at']); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="admin_edit.php?id=<?php echo sanitizeOutput($admin['id']); ?>"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="수정">
                                                        <i class="bi bi-pencil"></i> 수정
                                                    </a>
                                                    <?php if ($admin['id'] !== $currentAdmin['id']): ?>
                                                        <a href="admin_delete.php?id=<?php echo sanitizeOutput($admin['id']); ?>"
                                                           class="btn btn-sm btn-outline-danger"
                                                           title="삭제">
                                                            <i class="bi bi-trash"></i> 삭제
                                                        </a>
                                                    <?php else: ?>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                disabled
                                                                title="현재 로그인한 관리자는 삭제할 수 없습니다.">
                                                            <i class="bi bi-trash"></i> 삭제
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> 등록된 관리자가 없습니다.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
