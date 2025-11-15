<?php
/**
 * Freshield Email Mailer
 * Simple SMTP mailer using PHP mail() function with fallback
 *
 * For production, install PHPMailer via Composer:
 * composer require phpmailer/phpmailer
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

/**
 * Send email using PHPMailer if available, otherwise use PHP mail()
 *
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $body Email body (HTML)
 * @param string $from From email address (optional)
 * @param string $fromName From name (optional)
 * @return bool Success status
 */
function sendEmail($to, $subject, $body, $from = null, $fromName = null) {
    $from = $from ?? SMTP_FROM_EMAIL;
    $fromName = $fromName ?? SMTP_FROM_NAME;

    // Check if PHPMailer is available
    if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
        require_once __DIR__ . '/../../vendor/autoload.php';
        return sendEmailWithPHPMailer($to, $subject, $body, $from, $fromName);
    } else {
        // Fallback to PHP mail()
        return sendEmailWithPHPMail($to, $subject, $body, $from, $fromName);
    }
}

/**
 * Send email using PHPMailer
 */
function sendEmailWithPHPMailer($to, $subject, $body, $from, $fromName) {
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';

        // Recipients
        $mail->setFrom($from, $fromName);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Send email using PHP mail() function (fallback)
 */
function sendEmailWithPHPMail($to, $subject, $body, $from, $fromName) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: {$fromName} <{$from}>" . "\r\n";

    return mail($to, $subject, $body, $headers);
}

/**
 * Send inquiry notification to admin
 *
 * @param array $inquiry Inquiry data
 * @return bool Success status
 */
function sendInquiryNotification($inquiry) {
    $subject = '[Freshield] New Inquiry from ' . htmlspecialchars($inquiry['name']);

    $body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #2c3e50; color: white; padding: 20px; text-align: center; }
            .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #2c3e50; }
            .value { margin-top: 5px; padding: 10px; background: white; border-left: 3px solid #3498db; }
            .footer { text-align: center; padding: 20px; color: #777; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>New Inquiry Received</h2>
            </div>
            <div class="content">
                <div class="field">
                    <div class="label">Name:</div>
                    <div class="value">' . htmlspecialchars($inquiry['name']) . '</div>
                </div>

                <div class="field">
                    <div class="label">Company:</div>
                    <div class="value">' . htmlspecialchars($inquiry['company'] ?? 'N/A') . '</div>
                </div>

                <div class="field">
                    <div class="label">Email:</div>
                    <div class="value">' . htmlspecialchars($inquiry['email']) . '</div>
                </div>

                <div class="field">
                    <div class="label">Phone:</div>
                    <div class="value">' . htmlspecialchars($inquiry['phone'] ?? 'N/A') . '</div>
                </div>

                <div class="field">
                    <div class="label">Product Interest:</div>
                    <div class="value">' . htmlspecialchars($inquiry['product'] ?? 'N/A') . '</div>
                </div>

                <div class="field">
                    <div class="label">Message:</div>
                    <div class="value">' . nl2br(htmlspecialchars($inquiry['message'])) . '</div>
                </div>

                <div class="field">
                    <div class="label">Submitted:</div>
                    <div class="value">' . date('Y-m-d H:i:s') . '</div>
                </div>
            </div>
            <div class="footer">
                <p>This is an automated notification from Freshield.com</p>
                <p>Please log in to the admin panel to respond to this inquiry.</p>
            </div>
        </div>
    </body>
    </html>
    ';

    return sendEmail(ADMIN_EMAIL, $subject, $body);
}

/**
 * Send confirmation email to customer
 *
 * @param array $inquiry Inquiry data
 * @param string $lang Language (ko or en)
 * @return bool Success status
 */
function sendInquiryConfirmation($inquiry, $lang = 'ko') {
    $customerEmail = $inquiry['email'];

    if ($lang === 'en') {
        $subject = 'Thank you for your inquiry - Freshield';
        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #3498db; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                .footer { text-align: center; padding: 20px; color: #777; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>Thank You for Contacting Freshield</h2>
                </div>
                <div class="content">
                    <p>Dear ' . htmlspecialchars($inquiry['name']) . ',</p>
                    <p>Thank you for your inquiry. We have received your message and will respond as soon as possible.</p>
                    <p>Our customer service team typically responds within 1-2 business days.</p>
                    <p>Best regards,<br>Freshield Team</p>
                </div>
                <div class="footer">
                    <p>Freshield - Premium Vacuum Sealer Brand</p>
                    <p>Website: https://freshield.com | Email: freshield@freshield.com</p>
                </div>
            </div>
        </body>
        </html>
        ';
    } else {
        $subject = '문의 주셔서 감사합니다 - 후레쉴드';
        $body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #3498db; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                .footer { text-align: center; padding: 20px; color: #777; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>후레쉴드에 문의해 주셔서 감사합니다</h2>
                </div>
                <div class="content">
                    <p>' . htmlspecialchars($inquiry['name']) . ' 고객님께,</p>
                    <p>문의해 주셔서 감사합니다. 고객님의 메시지를 잘 받았으며, 최대한 빠른 시일 내에 답변 드리겠습니다.</p>
                    <p>고객지원팀은 일반적으로 영업일 기준 1-2일 이내에 답변 드립니다.</p>
                    <p>감사합니다.<br>후레쉴드 팀 드림</p>
                </div>
                <div class="footer">
                    <p>후레쉴드 - 프리미엄 진공포장기 브랜드</p>
                    <p>웹사이트: https://freshield.com | 이메일: freshield@freshield.com</p>
                </div>
            </div>
        </body>
        </html>
        ';
    }

    return sendEmail($customerEmail, $subject, $body);
}

?>
