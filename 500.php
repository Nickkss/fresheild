<?php
/**
 * 500 Error Page - Internal Server Error
 * Phase 4: Custom error handling
 */

http_response_code(500);

$lang = 'ko';
$is_english = false;

// Detect language from URL or referrer
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/en') !== false) {
    $lang = 'en';
    $is_english = true;
}

$pageTitle = $is_english ? '500 - Internal Server Error | Freshield' : '500 - 서버 오류 | 후레쉴드';
$pageDescription = $is_english ? 'An internal server error occurred.' : '서버에 오류가 발생했습니다.';

require_once __DIR__ . '/public/includes/config.php';
require_once __DIR__ . '/public/includes/header_optimized.php';
?>

<style>
.error-container {
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px 20px;
}

.error-content {
    max-width: 600px;
}

.error-code {
    font-size: 120px;
    font-weight: bold;
    color: #e74c3c;
    line-height: 1;
    margin-bottom: 20px;
}

.error-title {
    font-size: 32px;
    color: #2c3e50;
    margin-bottom: 20px;
}

.error-message {
    font-size: 18px;
    color: #666;
    margin-bottom: 40px;
    line-height: 1.6;
}

.error-links {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.error-link {
    display: inline-block;
    padding: 12px 30px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background 0.3s;
}

.error-link:hover {
    background: #2980b9;
    color: white;
    text-decoration: none;
}

.error-link.secondary {
    background: #95a5a6;
}

.error-link.secondary:hover {
    background: #7f8c8d;
}

.error-info {
    margin-top: 40px;
    padding: 30px;
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 8px;
    text-align: left;
}

.error-info h3 {
    color: #856404;
    margin-bottom: 15px;
}

.error-info p {
    color: #856404;
    margin: 10px 0;
}
</style>

<div class="error-container">
    <div class="error-content">
        <div class="error-code">500</div>

        <?php if ($is_english): ?>
            <h1 class="error-title">Internal Server Error</h1>
            <p class="error-message">
                We're sorry, but something went wrong on our server. Our team has been notified and is working to fix the issue.
            </p>
            <div class="error-links">
                <a href="/en_index.php" class="error-link">Return Home</a>
                <a href="/public/pages/contact_en.php" class="error-link secondary">Contact Support</a>
            </div>

            <div class="error-info">
                <h3>What happened?</h3>
                <p>
                    Our server encountered an unexpected error while processing your request.
                    This error has been logged and our technical team will investigate it.
                </p>
                <p>
                    <strong>What you can do:</strong>
                </p>
                <ul>
                    <li>Try refreshing the page</li>
                    <li>Go back to the <a href="/en_index.php">homepage</a></li>
                    <li>Try again in a few minutes</li>
                    <li>If the problem persists, please <a href="/public/pages/contact_en.php">contact us</a></li>
                </ul>
            </div>
        <?php else: ?>
            <h1 class="error-title">서버 오류가 발생했습니다</h1>
            <p class="error-message">
                죄송합니다. 서버에서 예기치 않은 오류가 발생했습니다. 저희 팀이 이 문제를 확인하고 해결하고 있습니다.
            </p>
            <div class="error-links">
                <a href="/index.php" class="error-link">홈으로 돌아가기</a>
                <a href="/public/pages/contact.php" class="error-link secondary">고객지원 문의</a>
            </div>

            <div class="error-info">
                <h3>무슨 일이 발생했나요?</h3>
                <p>
                    요청을 처리하는 중에 서버에서 예기치 않은 오류가 발생했습니다.
                    이 오류는 기록되었으며 기술팀에서 조사 중입니다.
                </p>
                <p>
                    <strong>다음을 시도해보세요:</strong>
                </p>
                <ul>
                    <li>페이지를 새로고침해보세요</li>
                    <li><a href="/index.php">홈페이지</a>로 돌아가기</li>
                    <li>잠시 후 다시 시도해보세요</li>
                    <li>문제가 계속되면 <a href="/public/pages/contact.php">문의</a>해주세요</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Log 500 error with details
error_log("500 Error: {$_SERVER['REQUEST_URI']} - User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'));

require_once __DIR__ . '/public/includes/footer.php';
?>
