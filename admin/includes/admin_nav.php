<?php
// Determine current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <div class="sidebar-brand">
        <a href="dashboard.php">
            <i class="bi bi-shield-check"></i> Freshield
        </a>
    </div>

    <div class="sidebar-menu">
        <a href="dashboard.php" class="menu-item <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
            <i class="bi bi-speedometer2"></i> 대시보드
        </a>

        <a href="faq_list.php" class="menu-item <?php echo strpos($current_page, 'faq') !== false ? 'active' : ''; ?>">
            <i class="bi bi-question-circle"></i> FAQ 관리
        </a>

        <a href="manual_list.php" class="menu-item <?php echo strpos($current_page, 'manual') !== false ? 'active' : ''; ?>">
            <i class="bi bi-file-earmark-text"></i> 자료실 관리
        </a>

        <?php if (isset($currentAdmin) && $currentAdmin['role'] === 'superadmin'): ?>
        <a href="admins.php" class="menu-item <?php echo strpos($current_page, 'admin') !== false && $current_page !== 'dashboard' ? 'active' : ''; ?>">
            <i class="bi bi-people"></i> 관리자 관리
        </a>
        <?php endif; ?>

        <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 15px;">

        <a href="logout.php" class="menu-item">
            <i class="bi bi-box-arrow-right"></i> 로그아웃
        </a>
    </div>
</div>

<!-- Main Content Area -->
<div class="main-content">
    <div class="topbar">
        <div class="topbar-title">
            <?php echo $pageTitle ?? 'Freshield 관리자'; ?>
        </div>
        <div class="admin-profile">
            <div class="admin-avatar">
                <?php echo strtoupper(substr($currentAdmin['username'] ?? 'A', 0, 1)); ?>
            </div>
            <div>
                <strong><?php echo htmlspecialchars($currentAdmin['username'] ?? 'Admin'); ?></strong>
                <br>
                <small class="text-muted">
                    <?php
                    if (isset($currentAdmin['role'])) {
                        echo $currentAdmin['role'] === 'superadmin' ? '슈퍼관리자' : '관리자';
                    }
                    ?>
                </small>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <?php displayFlashMessage(); ?>
