<?php
/**
 * Admin Login Page
 * Phase 3: Admin Panel Authentication
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Include helpers
require_once __DIR__ . '/includes/admin_helpers.php';

// Create default admin if none exists
createDefaultAdmin();

$error = '';
$isBlocked = false;
$blockedMinutes = 0;

// PHASE 4: Check rate limiting
$clientIP = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rateLimit = checkLoginRateLimit($clientIP);

if ($rateLimit['blocked']) {
    $isBlocked = true;
    $blockedMinutes = $rateLimit['wait_minutes'];
    $error = "너무 많은 로그인 시도로 인해 계정이 잠겼습니다. {$blockedMinutes}분 후에 다시 시도해주세요.";
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$isBlocked) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = '사용자명과 비밀번호를 입력해주세요.';
        // Log failed attempt - empty credentials
        logAdminLogin(null, $username ?: 'empty', 'failed', '빈 사용자명 또는 비밀번호');
    } else {
        // Verify credentials
        $admin = verifyAdminCredentials($username, $password);

        if ($admin) {
            // PHASE 4: Log successful login
            logAdminLogin($admin['id'], $username, 'success');

            // PHASE 4: Update last login info
            updateAdminLastLogin($admin['id']);

            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            // Set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_role'] = $admin['role'];
            $_SESSION['admin_session_id'] = session_id();
            $_SESSION['admin_last_activity'] = time();

            // Redirect to dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            // PHASE 4: Log failed login
            logAdminLogin(null, $username, 'failed', '잘못된 사용자명 또는 비밀번호');

            $error = '사용자명 또는 비밀번호가 올바르지 않습니다.';

            // Check if now blocked after this attempt
            $newRateLimit = checkLoginRateLimit($clientIP);
            if ($newRateLimit['blocked']) {
                $error .= " 너무 많은 시도로 인해 {$newRateLimit['wait_minutes']}분간 로그인이 차단되었습니다.";
            }
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $isBlocked) {
    // PHASE 4: Log blocked attempt
    logAdminLogin(null, $_POST['username'] ?? 'unknown', 'blocked', "IP 차단됨 ({$blockedMinutes}분)");
}

// Check for timeout message
$timeoutMessage = isset($_GET['timeout']) ? '세션이 만료되었습니다. 다시 로그인해주세요.' : '';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 로그인 - Freshield Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-logo h1 {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }
        .login-logo p {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .default-credentials {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 13px;
        }
        .default-credentials strong {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1>🔐 Freshield Admin</h1>
            <p>관리자 로그인</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($timeoutMessage): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($timeoutMessage); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">사용자명</label>
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="사용자명을 입력하세요" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">비밀번호</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="비밀번호를 입력하세요" required>
            </div>

            <button type="submit" class="btn btn-primary btn-login w-100">로그인</button>
        </form>

        <div class="default-credentials">
            <strong>기본 로그인 정보:</strong><br>
            사용자명: <code>admin</code><br>
            비밀번호: <code>admin123</code><br>
            <small class="text-muted">최초 로그인 후 반드시 비밀번호를 변경하세요.</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
