<?php
/**
 * Maintenance Mode Page
 * Phase 4: Maintenance page for planned downtime
 *
 * To enable maintenance mode:
 * 1. Uncomment the maintenance redirect section in .htaccess
 * 2. All traffic will be redirected to this page
 */

http_response_code(503);
header('Retry-After: 3600'); // Retry after 1 hour

$lang = 'ko';
$is_english = false;

// Detect language
if (isset($_GET['lang']) && $_GET['lang'] === 'en') {
    $lang = 'en';
    $is_english = true;
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $is_english ? 'Maintenance Mode - Freshield' : '시스템 점검 중 - 후레쉴드'; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Noto Sans KR', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .maintenance-container {
            max-width: 600px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            text-align: center;
        }

        .maintenance-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            color: white;
        }

        .maintenance-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: rotate 3s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .maintenance-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .maintenance-header p {
            font-size: 18px;
            opacity: 0.9;
        }

        .maintenance-body {
            padding: 40px 30px;
        }

        .maintenance-message {
            font-size: 16px;
            color: #555;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .maintenance-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .maintenance-info p {
            color: #666;
            margin: 10px 0;
        }

        .maintenance-info strong {
            color: #333;
        }

        .language-toggle {
            margin-top: 20px;
        }

        .language-toggle a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-weight: bold;
        }

        .language-toggle a:hover {
            text-decoration: underline;
        }

        .social-links {
            margin-top: 30px;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            font-size: 14px;
            text-decoration: none;
        }

        .social-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .maintenance-header h1 {
                font-size: 24px;
            }

            .maintenance-icon {
                font-size: 60px;
            }

            .maintenance-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-header">
            <div class="maintenance-icon">⚙️</div>
            <h1><?php echo $is_english ? 'Maintenance in Progress' : '시스템 점검 중입니다'; ?></h1>
            <p><?php echo $is_english ? 'We\'ll be back soon!' : '곧 다시 찾아뵙겠습니다!'; ?></p>
        </div>

        <div class="maintenance-body">
            <?php if ($is_english): ?>
                <div class="maintenance-message">
                    <p>
                        We are currently performing scheduled maintenance to improve our services.
                        We apologize for any inconvenience this may cause.
                    </p>
                </div>

                <div class="maintenance-info">
                    <p><strong>Estimated Duration:</strong> 1-2 hours</p>
                    <p><strong>Expected Completion:</strong> Soon</p>
                    <p><strong>Contact:</strong> freshield@freshield.com</p>
                </div>

                <p style="color: #666;">
                    Thank you for your patience and understanding.<br>
                    The Freshield Team
                </p>
            <?php else: ?>
                <div class="maintenance-message">
                    <p>
                        더 나은 서비스를 제공하기 위해 현재 시스템 점검을 진행하고 있습니다.
                        이용에 불편을 드려 죄송합니다.
                    </p>
                </div>

                <div class="maintenance-info">
                    <p><strong>예상 소요 시간:</strong> 1-2시간</p>
                    <p><strong>완료 예정:</strong> 곧 완료 예정</p>
                    <p><strong>문의:</strong> freshield@freshield.com</p>
                </div>

                <p style="color: #666;">
                    양해해 주셔서 감사합니다.<br>
                    후레쉴드 팀 드림
                </p>
            <?php endif; ?>

            <div class="language-toggle">
                <a href="?lang=ko">한국어</a> | <a href="?lang=en">English</a>
            </div>

            <div class="social-links">
                <p style="color: #999; font-size: 14px; margin-bottom: 10px;">
                    <?php echo $is_english ? 'Stay updated:' : '소식을 확인하세요:'; ?>
                </p>
                <a href="mailto:freshield@freshield.com">Email</a>
                <a href="tel:+82-31-488-7777"><?php echo $is_english ? 'Phone' : '전화'; ?></a>
            </div>
        </div>
    </div>
</body>
</html>
