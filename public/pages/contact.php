<?php
/**
 * Contact Form - Korean Version
 * Phase 4: Contact form with inquiry system
 */

$lang = 'ko';
$is_english = false;

// Set page metadata for SEO
$pageTitle = '문의하기 - 후레쉴드 | Freshield';
$pageDescription = '후레쉴드 제품에 대한 문의사항을 남겨주세요. 빠른 시일 내에 답변 드리겠습니다.';
$pageKeywords = '문의하기,고객지원,후레쉴드,freshield,contact';

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/mailer.php';

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$success = false;
$error = '';
$formData = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = '잘못된 요청입니다. 페이지를 새로고침하고 다시 시도해주세요.';
    } else {
        // Get and sanitize form data
        $name = trim($_POST['name'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $product = trim($_POST['product'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Validation
        if (empty($name)) {
            $error = '이름을 입력해주세요.';
        } elseif (empty($email)) {
            $error = '이메일을 입력해주세요.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = '올바른 이메일 주소를 입력해주세요.';
        } elseif (empty($message)) {
            $error = '문의내용을 입력해주세요.';
        } else {
            // Save to database
            try {
                $pdo = db_connect();
                $stmt = $pdo->prepare("
                    INSERT INTO inquiries (name, company, email, phone, product, message, ip_address, user_agent)
                    VALUES (:name, :company, :email, :phone, :product, :message, :ip_address, :user_agent)
                ");

                $stmt->execute([
                    'name' => $name,
                    'company' => $company,
                    'email' => $email,
                    'phone' => $phone,
                    'product' => $product,
                    'message' => $message,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
                ]);

                // Send email notifications
                $inquiryData = [
                    'name' => $name,
                    'company' => $company,
                    'email' => $email,
                    'phone' => $phone,
                    'product' => $product,
                    'message' => $message
                ];

                sendInquiryNotification($inquiryData);
                sendInquiryConfirmation($inquiryData, 'ko');

                $success = true;

                // Generate new CSRF token
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            } catch (Exception $e) {
                error_log("Contact form error: " . $e->getMessage());
                $error = '문의 접수 중 오류가 발생했습니다. 잠시 후 다시 시도해주세요.';
            }
        }

        // Keep form data for re-display on error
        if (!$success) {
            $formData = $_POST;
        }
    }
}

require_once __DIR__ . '/../includes/header_optimized.php';
?>

<style>
.contact-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 0 20px;
}

.contact-header {
    text-align: center;
    margin-bottom: 40px;
}

.contact-header h1 {
    font-size: 32px;
    color: #2c3e50;
    margin-bottom: 10px;
}

.contact-header p {
    color: #666;
    font-size: 16px;
}

.contact-form {
    background: #fff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

.form-group label .required {
    color: #e74c3c;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    font-family: Arial, sans-serif;
    box-sizing: border-box;
}

.form-group textarea {
    min-height: 150px;
    resize: vertical;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.btn-submit {
    background: #3498db;
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn-submit:hover {
    background: #2980b9;
}

.contact-info {
    margin-top: 40px;
    padding: 30px;
    background: #f8f9fa;
    border-radius: 8px;
}

.contact-info h3 {
    color: #2c3e50;
    margin-bottom: 20px;
}

.contact-info p {
    margin: 10px 0;
    color: #555;
}
</style>

<div class="contact-container">
    <div class="contact-header">
        <h1>문의하기</h1>
        <p>제품에 대한 문의사항을 남겨주시면 빠른 시일 내에 답변 드리겠습니다.</p>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <strong>문의가 성공적으로 접수되었습니다!</strong><br>
            입력하신 이메일로 확인 메일이 발송되었습니다. 빠른 시일 내에 답변 드리겠습니다.<br>
            감사합니다.
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="/index.php" style="color: #3498db; text-decoration: none;">홈으로 돌아가기</a>
        </div>
    <?php else: ?>
        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="contact-form">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

            <div class="form-group">
                <label>이름 <span class="required">*</span></label>
                <input type="text" name="name" required value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>" placeholder="홍길동">
            </div>

            <div class="form-group">
                <label>회사명</label>
                <input type="text" name="company" value="<?php echo htmlspecialchars($formData['company'] ?? ''); ?>" placeholder="(주)회사명">
            </div>

            <div class="form-group">
                <label>이메일 <span class="required">*</span></label>
                <input type="email" name="email" required value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" placeholder="example@email.com">
            </div>

            <div class="form-group">
                <label>연락처</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>" placeholder="010-0000-0000">
            </div>

            <div class="form-group">
                <label>관심 제품</label>
                <select name="product">
                    <option value="">선택해주세요</option>
                    <option value="OUTDOOR" <?php echo ($formData['product'] ?? '') === 'OUTDOOR' ? 'selected' : ''; ?>>아웃도어</option>
                    <option value="ADVANCE" <?php echo ($formData['product'] ?? '') === 'ADVANCE' ? 'selected' : ''; ?>>어드밴스</option>
                    <option value="ELITE" <?php echo ($formData['product'] ?? '') === 'ELITE' ? 'selected' : ''; ?>>엘리트</option>
                    <option value="GENISYS" <?php echo ($formData['product'] ?? '') === 'GENISYS' ? 'selected' : ''; ?>>제니시스</option>
                    <option value="HAND_PUMP" <?php echo ($formData['product'] ?? '') === 'HAND_PUMP' ? 'selected' : ''; ?>>핸드펌프</option>
                    <option value="ROLL_BAG" <?php echo ($formData['product'] ?? '') === 'ROLL_BAG' ? 'selected' : ''; ?>>롤앤백</option>
                    <option value="OTHER" <?php echo ($formData['product'] ?? '') === 'OTHER' ? 'selected' : ''; ?>>기타</option>
                </select>
            </div>

            <div class="form-group">
                <label>문의내용 <span class="required">*</span></label>
                <textarea name="message" required placeholder="문의하실 내용을 자세히 입력해주세요."><?php echo htmlspecialchars($formData['message'] ?? ''); ?></textarea>
            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn-submit">문의하기</button>
            </div>
        </form>
    <?php endif; ?>

    <div class="contact-info">
        <h3>고객지원 안내</h3>
        <p><strong>이메일:</strong> freshield@freshield.com</p>
        <p><strong>전화:</strong> 031-488-7777</p>
        <p><strong>운영시간:</strong> 평일 오전 9시 ~ 오후 6시 (주말 및 공휴일 휴무)</p>
        <p><strong>주소:</strong> 경기도 시흥시 마유로118번길 11</p>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
