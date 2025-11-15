<?php
/**
 * Freshield Dynamic XML Sitemap Generator
 * Automatically generates sitemap based on pages and database content
 *
 * Access: https://freshield.com/sitemap.xml.php
 * Or setup rewrite rule: sitemap.xml → sitemap.xml.php
 */

header('Content-Type: application/xml; charset=UTF-8');

require_once __DIR__ . '/public/includes/config.php';
require_once __DIR__ . '/public/includes/db.php';

$baseUrl = 'https://freshield.com';
$today = date('Y-m-d');

// Static pages with their priorities and change frequencies
$staticPages = [
    // Korean pages
    ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'weekly', 'lastmod' => $today],
    ['loc' => '/public/pages/brandstory.php', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/public/pages/certification.php', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/public/pages/product_freshield.php', 'priority' => '0.9', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_outdoor4.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_advance.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_elite.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_genisys.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_handpump.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_rollbag.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/tip.php', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/public/pages/faq.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/manual.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/contact.php', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/public/pages/sitemap.php', 'priority' => '0.5', 'changefreq' => 'monthly'],

    // English pages
    ['loc' => '/en_index.php', 'priority' => '1.0', 'changefreq' => 'weekly', 'lastmod' => $today],
    ['loc' => '/public/pages/brandstory_en.php', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/public/pages/product_freshield_en.php', 'priority' => '0.9', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_outdoor1_en.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_advance_en.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_elite_en.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_genisys_en.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_handpump_en.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/product_rollbag_en.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/tip_en.php', 'priority' => '0.7', 'changefreq' => 'monthly'],
    ['loc' => '/public/pages/faq_en.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/manual_en.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['loc' => '/public/pages/contact_en.php', 'priority' => '0.7', 'changefreq' => 'monthly'],
];

// Get dynamic content last modification dates from database
try {
    $pdo = getPDO();

    // Get last updated FAQ dates
    $stmt = $pdo->query("
        SELECT language, MAX(updated_at) as last_update
        FROM faqs
        WHERE is_active = 1
        GROUP BY language
    ");
    $faqDates = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // Get last updated Manual dates
    $stmt = $pdo->query("
        SELECT language, MAX(updated_at) as last_update
        FROM manuals
        WHERE is_active = 1
        GROUP BY language
    ");
    $manualDates = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

} catch (PDOException $e) {
    $faqDates = [];
    $manualDates = [];
}

// Update lastmod for FAQ and Manual pages based on DB data
foreach ($staticPages as &$page) {
    if (strpos($page['loc'], 'faq.php') !== false) {
        $lang = (strpos($page['loc'], '_en.php') !== false) ? 'en' : 'ko';
        if (isset($faqDates[$lang])) {
            $page['lastmod'] = date('Y-m-d', strtotime($faqDates[$lang]));
        }
    }
    if (strpos($page['loc'], 'manual.php') !== false) {
        $lang = (strpos($page['loc'], '_en.php') !== false) ? 'en' : 'ko';
        if (isset($manualDates[$lang])) {
            $page['lastmod'] = date('Y-m-d', strtotime($manualDates[$lang]));
        }
    }
}
unset($page); // Break reference

// Start XML output
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($staticPages as $page): ?>
    <url>
        <loc><?php echo htmlspecialchars($baseUrl . $page['loc']); ?></loc>
        <?php if (isset($page['lastmod'])): ?>
        <lastmod><?php echo $page['lastmod']; ?></lastmod>
        <?php endif; ?>
        <changefreq><?php echo $page['changefreq']; ?></changefreq>
        <priority><?php echo $page['priority']; ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
