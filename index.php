<?php
// Set language to Korean
$lang = 'ko';
$is_english = false;

// Set page metadata for SEO
$pageTitle = '후레쉴드 - Freshield | 진공포장기 전문 브랜드';
$pageDescription = '프리미엄 진공포장기 브랜드 후레쉴드. 신선도를 지키는 스마트한 선택. 진공포장기, 진공용기, 롤앤백 제품을 만나보세요.';
$pageKeywords = '진공포장기,진공용기,진공백,후레쉴드,freshield,vacuum sealer,식품보관,신선도유지';

// Add Organization structured data
$structuredData = [
    "@context" => "https://schema.org",
    "@type" => "Organization",
    "name" => "Freshield",
    "alternateName" => "후레쉴드",
    "url" => "https://freshield.com",
    "logo" => "https://freshield.com/public/assets/images/top_logo.png",
    "description" => "프리미엄 진공포장기 전문 브랜드",
    "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => "마유로118번길 11",
        "addressLocality" => "시흥시",
        "addressRegion" => "경기도",
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

// Include Korean home page content
include __DIR__.'/public/pages/home.php';

// Include footer
include __DIR__.'/public/includes/footer.php';
?>
