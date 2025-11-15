<?php
/**
 * Contact Form - English Version
 * Phase 4: Contact form with inquiry system
 */

$lang = 'en';
$is_english = true;

// Set page metadata for SEO
$pageTitle = 'Contact Us - Freshield | Premium Vacuum Sealer Brand';
$pageDescription = 'Get in touch with Freshield. We are here to answer your questions about our premium vacuum sealer products.';
$pageKeywords = 'contact,customer support,freshield,vacuum sealer,inquiry';

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
        $error = 'Invalid request. Please refresh the page and try again.';
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
            $error = 'Please enter your name.';
        } elseif (empty($email)) {
            $error = 'Please enter your email address.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (empty($message)) {
            $error = 'Please enter your message.';
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
                sendInquiryConfirmation($inquiryData, 'en');

                $success = true;

                // Generate new CSRF token
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            } catch (Exception $e) {
                error_log("Contact form error: " . $e->getMessage());
                $error = 'An error occurred while submitting your inquiry. Please try again later.';
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
        <h1>Contact Us</h1>
        <p>Please leave your inquiry and we will respond as soon as possible.</p>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <strong>Your inquiry has been successfully submitted!</strong><br>
            A confirmation email has been sent to your email address. We will respond to you shortly.<br>
            Thank you.
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="/en_index.php" style="color: #3498db; text-decoration: none;">Return to Home</a>
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
                <label>Name <span class="required">*</span></label>
                <input type="text" name="name" required value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>" placeholder="John Doe">
            </div>

            <div class="form-group">
                <label>Company</label>
                <input type="text" name="company" value="<?php echo htmlspecialchars($formData['company'] ?? ''); ?>" placeholder="Company Name">
            </div>

            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <input type="email" name="email" required value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" placeholder="example@email.com">
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>" placeholder="+1-234-567-8900">
            </div>

            <div class="form-group">
                <label>Product Interest</label>
                <select name="product">
                    <option value="">Please select</option>
                    <option value="OUTDOOR" <?php echo ($formData['product'] ?? '') === 'OUTDOOR' ? 'selected' : ''; ?>>OUTDOOR</option>
                    <option value="ADVANCE" <?php echo ($formData['product'] ?? '') === 'ADVANCE' ? 'selected' : ''; ?>>ADVANCE</option>
                    <option value="ELITE" <?php echo ($formData['product'] ?? '') === 'ELITE' ? 'selected' : ''; ?>>ELITE</option>
                    <option value="GENISYS" <?php echo ($formData['product'] ?? '') === 'GENISYS' ? 'selected' : ''; ?>>GENISYS</option>
                    <option value="HAND_PUMP" <?php echo ($formData['product'] ?? '') === 'HAND_PUMP' ? 'selected' : ''; ?>>HAND PUMP</option>
                    <option value="ROLL_BAG" <?php echo ($formData['product'] ?? '') === 'ROLL_BAG' ? 'selected' : ''; ?>>Rolls & Bags</option>
                    <option value="OTHER" <?php echo ($formData['product'] ?? '') === 'OTHER' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Message <span class="required">*</span></label>
                <textarea name="message" required placeholder="Please enter your message in detail."><?php echo htmlspecialchars($formData['message'] ?? ''); ?></textarea>
            </div>

            <div style="text-align: center;">
                <button type="submit" class="btn-submit">Submit Inquiry</button>
            </div>
        </form>
    <?php endif; ?>

    <div class="contact-info">
        <h3>Customer Support</h3>
        <p><strong>Email:</strong> freshield@freshield.com</p>
        <p><strong>Phone:</strong> +82-31-488-7777</p>
        <p><strong>Business Hours:</strong> Weekdays 9 AM - 6 PM (Closed on weekends and holidays)</p>
        <p><strong>Address:</strong> 11 Mayuro118beongil, Siheung-si, Gyeonggi-do, South Korea</p>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
