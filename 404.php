<?php
/**
 * 404 Error Page - Page Not Found
 * Phase 4: Custom error handling
 */

http_response_code(404);

$lang = 'ko';
$is_english = false;

// Detect language from URL or referrer
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/en') !== false) {
    $lang = 'en';
    $is_english = true;
}

$pageTitle = $is_english ? '404 - Page Not Found | Freshield' : '404 - 페이지를 찾을 수 없습니다 | 후레쉴드';
$pageDescription = $is_english ? 'The requested page could not be found.' : '요청하신 페이지를 찾을 수 없습니다.';

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
    color: #3498db;
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

.error-suggestions {
    margin-top: 40px;
    padding: 30px;
    background: #f8f9fa;
    border-radius: 8px;
    text-align: left;
}

.error-suggestions h3 {
    color: #2c3e50;
    margin-bottom: 15px;
}

.error-suggestions ul {
    list-style: none;
    padding: 0;
}

.error-suggestions li {
    padding: 8px 0;
    color: #555;
}

.error-suggestions li:before {
    content: "→ ";
    color: #3498db;
    font-weight: bold;
    margin-right: 10px;
}
</style>

<div class="error-container">
    <div class="error-content">
        <div class="error-code">404</div>

        <?php if ($is_english): ?>
            <h1 class="error-title">Page Not Found</h1>
            <p class="error-message">
                Sorry, the page you are looking for could not be found. It may have been moved, deleted, or the URL might be incorrect.
            </p>
            <div class="error-links">
                <a href="/en_index.php" class="error-link">Return Home</a>
                <a href="/public/pages/contact_en.php" class="error-link secondary">Contact Us</a>
            </div>

            <div class="error-suggestions">
                <h3>What you can do:</h3>
                <ul>
                    <li>Check the URL for typos</li>
                    <li>Go back to the <a href="/en_index.php">homepage</a></li>
                    <li>Browse our <a href="/public/pages/product_freshield_en.php">products</a></li>
                    <li>Visit our <a href="/public/pages/faq_en.php">FAQ page</a></li>
                    <li><a href="/public/pages/contact_en.php">Contact us</a> if you need assistance</li>
                </ul>
            </div>
        <?php else: ?>
            <h1 class="error-title">페이지를 찾을 수 없습니다</h1>
            <p class="error-message">
                죄송합니다. 요청하신 페이지를 찾을 수 없습니다. 페이지가 이동되었거나 삭제되었을 수 있으며, URL이 잘못되었을 수 있습니다.
            </p>
            <div class="error-links">
                <a href="/index.php" class="error-link">홈으로 돌아가기</a>
                <a href="/public/pages/contact.php" class="error-link secondary">문의하기</a>
            </div>

            <div class="error-suggestions">
                <h3>다음을 시도해보세요:</h3>
                <ul>
                    <li>URL의 오타를 확인해주세요</li>
                    <li><a href="/index.php">홈페이지</a>로 돌아가기</li>
                    <li><a href="/public/pages/product_freshield.php">제품 페이지</a> 둘러보기</li>
                    <li><a href="/public/pages/faq.php">FAQ 페이지</a> 방문하기</li>
                    <li>도움이 필요하시면 <a href="/public/pages/contact.php">문의하기</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Log 404 error
error_log("404 Error: {$_SERVER['REQUEST_URI']} - Referrer: " . ($_SERVER['HTTP_REFERER'] ?? 'Direct'));

require_once __DIR__ . '/public/includes/footer.php';
?>
