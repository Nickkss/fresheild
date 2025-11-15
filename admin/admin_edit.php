<?php
/**
 * Admin User Management - Create/Edit Page
 *
 * SUPERADMIN ONLY - Create new admin or edit existing admin
 * Phase 3: Admin Panel Security
 */

require_once __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/includes/admin_helpers.php';

// SECURITY: Check if user is SUPERADMIN
requireSuperadmin();

// Determine if we're editing or creating
$isEdit = isset($_GET['id']) && is_numeric($_GET['id']);
$adminId = $isEdit ? (int)$_GET['id'] : null;
$admin = null;
$errors = [];

// If editing, fetch existing admin
if ($isEdit) {
    try {
        $pdo = getPDO();
        $stmt = $pdo->prepare("
            SELECT id, username, role, created_at
            FROM admins
            WHERE id = :id
        ");
        $stmt->execute(['id' => $adminId]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$admin) {
            redirectWithMessage('admins.php', '관리자를 찾을 수 없습니다.', 'error');
            exit;
        }
    } catch (PDOException $e) {
        error_log("Admin Fetch Error: " . $e->getMessage());
        redirectWithMessage('admins.php', '관리자 로드 중 오류가 발생했습니다.', 'error');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !csrf_validate_token($_POST['csrf_token'])) {
        redirectWithMessage('admins.php', 'CSRF 토큰이 유효하지 않습니다.', 'error');
        exit;
    }

    // Get and validate form data
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';

    // Validation
    if (empty($username)) {
        $errors[] = '사용자명은 필수 항목입니다.';
    }

    if (!$isEdit && empty($password)) {
        $errors[] = '비밀번호는 필수 항목입니다.';
    }

    if (!empty($password) && empty($password_confirm)) {
        $errors[] = '비밀번호 확인은 필수 항목입니다.';
    }

    if (!empty($password) && $password !== $password_confirm) {
        $errors[] = '비밀번호가 일치하지 않습니다.';
    }

    if (empty($role) || !in_array($role, ['admin', 'superadmin'])) {
        $errors[] = '유효한 역할을 선택해주세요.';
    }

    // Check if username already exists (for new admins or if changing username)
    if (!empty($username) && (!$isEdit || ($isEdit && $admin['username'] !== $username))) {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = :username");
            $stmt->execute(['username' => $username]);
            if ($stmt->fetch()) {
                $errors[] = '이미 존재하는 사용자명입니다.';
            }
        } catch (PDOException $e) {
            error_log("Username check error: " . $e->getMessage());
            $errors[] = '사용자명 확인 중 오류가 발생했습니다.';
        }
    }

    if (empty($errors)) {
        try {
            $pdo = getPDO();

            if ($isEdit) {
                // Update existing admin
                if (!empty($password)) {
                    // Update with new password
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("
                        UPDATE admins
                        SET username = :username, password_hash = :password_hash, role = :role, updated_at = NOW()
                        WHERE id = :id
                    ");
                    $stmt->execute([
                        'username' => $username,
                        'password_hash' => $passwordHash,
                        'role' => $role,
                        'id' => $adminId
                    ]);
                } else {
                    // Update without changing password
                    $stmt = $pdo->prepare("
                        UPDATE admins
                        SET username = :username, role = :role, updated_at = NOW()
                        WHERE id = :id
                    ");
                    $stmt->execute([
                        'username' => $username,
                        'role' => $role,
                        'id' => $adminId
                    ]);
                }
                redirectWithMessage('admins.php', '관리자가 성공적으로 수정되었습니다.', 'success');
            } else {
                // Insert new admin
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("
                    INSERT INTO admins (username, password_hash, role, created_at, updated_at)
                    VALUES (:username, :password_hash, :role, NOW(), NOW())
                ");
                $stmt->execute([
                    'username' => $username,
                    'password_hash' => $passwordHash,
                    'role' => $role
                ]);
                redirectWithMessage('admins.php', '새 관리자가 성공적으로 추가되었습니다.', 'success');
            }
            exit;
        } catch (PDOException $e) {
            error_log("Admin Save Error: " . $e->getMessage());
            $errors[] = '관리자 저장 중 오류가 발생했습니다.';
        }
    }
}

$pageTitle = $isEdit ? '관리자 수정' : '관리자 추가';
include __DIR__ . '/includes/admin_header.php';
include __DIR__ . '/includes/admin_nav.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?php echo sanitizeOutput($pageTitle); ?></h2>
                <a href="admins.php" class="btn btn-secondary">
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
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>오류가 발생했습니다:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo sanitizeOutput($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($isEdit): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>주의:</strong> 사용자명은 변경할 수 없습니다. 비밀번호를 변경하려면 새 비밀번호를 입력하세요.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo $isEdit ? 'admin_edit.php?id=' . $adminId : 'admin_edit.php'; ?>">
                        <?php csrf_field(); ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">
                                사용자명 <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="username"
                                   id="username"
                                   class="form-control"
                                   value="<?php echo sanitizeOutput($admin['username'] ?? $_POST['username'] ?? ''); ?>"
                                   required
                                   <?php echo $isEdit ? 'readonly' : ''; ?>
                                   placeholder="관리자 사용자명을 입력하세요">
                            <?php if ($isEdit): ?>
                                <small class="form-text text-muted">사용자명은 변경할 수 없습니다.</small>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                비밀번호 <span class="text-danger">*</span>
                                <?php if ($isEdit): ?>
                                    <span class="text-muted">(선택사항)</span>
                                <?php endif; ?>
                            </label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   <?php echo !$isEdit ? 'required' : ''; ?>
                                   placeholder="<?php echo $isEdit ? '비밀번호를 변경하려면 입력하세요' : '비밀번호를 입력하세요'; ?>">
                            <small class="form-text text-muted">
                                <?php echo $isEdit ? '비밀번호를 변경하지 않으려면 비워두세요.' : ''; ?>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">
                                비밀번호 확인 <span class="text-danger">*</span>
                                <?php if ($isEdit): ?>
                                    <span class="text-muted">(선택사항)</span>
                                <?php endif; ?>
                            </label>
                            <input type="password"
                                   name="password_confirm"
                                   id="password_confirm"
                                   class="form-control"
                                   placeholder="비밀번호를 다시 입력하세요">
                            <small class="form-text text-muted">입력한 비밀번호와 일치해야 합니다.</small>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label">
                                역할 <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">선택하세요</option>
                                <option value="admin" <?php echo ($admin && $admin['role'] === 'admin') || (!$admin && isset($_POST['role']) && $_POST['role'] === 'admin') ? 'selected' : ''; ?>>
                                    관리자 (admin)
                                </option>
                                <option value="superadmin" <?php echo ($admin && $admin['role'] === 'superadmin') || (!$admin && isset($_POST['role']) && $_POST['role'] === 'superadmin') ? 'selected' : ''; ?>>
                                    슈퍼관리자 (superadmin)
                                </option>
                            </select>
                            <small class="form-text text-muted">
                                슈퍼관리자만 다른 관리자를 추가/수정/삭제할 수 있습니다.
                            </small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="admins.php" class="btn btn-secondary">
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

<?php include __DIR__ . '/includes/admin_footer.php'; ?>
