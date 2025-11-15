<?php
// Set language to English
$lang = 'en';
$is_english = true;

// Set page metadata for SEO
$pageTitle = 'Freshield | Premium Vacuum Sealer Brand';
$pageDescription = 'Freshield - Premium vacuum sealer brand. Smart choice for freshness. Discover our vacuum sealers, canisters, and roll bags.';
$pageKeywords = 'vacuum sealer,vacuum canister,vacuum bags,freshield,food storage,freshness preservation';

// Add Organization structured data
$structuredData = [
    "@context" => "https://schema.org",
    "@type" => "Organization",
    "name" => "Freshield",
    "alternateName" => "후레쉴드",
    "url" => "https://freshield.com",
    "logo" => "https://freshield.com/public/assets/images/top_logo.png",
    "description" => "Premium vacuum sealer brand",
    "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => "11 Mayuro118beongil",
        "addressLocality" => "Siheung-si",
        "addressRegion" => "Gyeonggi-do",
        "postalCode" => "15073",
        "addressCountry" => "KR"
    ],
    "contactPoint" => [
        "@type" => "ContactPoint",
        "telephone" => "+82-31-488-7777",
        "contactType" => "customer service",
        "email" => "freshield@freshield.com",
        "availableLanguage" => ["Korean", "English"]
    ],
    "sameAs" => [
        "https://freshield.com"
    ]
];

// Include header
include __DIR__.'/public/includes/header_optimized.php';

// Include English home page content
include __DIR__.'/public/pages/home_en.php';

// Include footer
include __DIR__.'/public/includes/footer.php';
?>
