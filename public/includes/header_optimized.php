<!DOCTYPE html>
<html lang="<?php echo isset($lang) ? htmlspecialchars($lang) : 'ko'; ?>">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
/**
 * SEO Metadata System
 * Dynamically set per page
 */
$defaultTitle = '후레쉴드 - Freshield | 진공포장기 전문 브랜드';
$defaultDescription = '프리미엄 진공포장기 브랜드 후레쉴드. 신선도를 지키는 스마트한 선택. 진공포장기, 진공용기, 롤앤백 제품을 만나보세요.';
$defaultImage = 'https://freshield.com/public/assets/images/og-image.jpg';
$canonical = 'https://freshield.com' . htmlspecialchars($_SERVER['REQUEST_URI']);

// Override with page-specific values if set
$pageTitle = isset($pageTitle) ? $pageTitle : $defaultTitle;
$pageDescription = isset($pageDescription) ? $pageDescription : $defaultDescription;
$pageImage = isset($pageImage) ? $pageImage : $defaultImage;
$pageKeywords = isset($pageKeywords) ? $pageKeywords : '진공포장기,진공용기,진공백,후레쉴드,freshield,vacuum sealer';
?>

<title><?php echo htmlspecialchars($pageTitle); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
<meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords); ?>">
<meta name="author" content="CSE Co., Ltd.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo $canonical; ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo $canonical; ?>">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
<meta property="og:image" content="<?php echo $pageImage; ?>">
<meta property="og:locale" content="<?php echo ($lang === 'en') ? 'en_US' : 'ko_KR'; ?>">
<meta property="og:site_name" content="Freshield">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?php echo $canonical; ?>">
<meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
<meta name="twitter:image" content="<?php echo $pageImage; ?>">

<!-- Favicon -->
<link rel="icon" href="/public/assets/images/favicon.ico" type="image/x-icon">

<!-- DNS Prefetch & Preconnect for Performance -->
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://ajax.googleapis.com">

<!-- Preload Critical Assets -->
<link rel="preload" href="/public/assets/images/top_logo.png" as="image">
<link rel="preload" href="/public/assets/css/main_layout.css" as="style">

<?php
// Asset loading based on environment
$isDevelopment = (!defined('APP_ENV') || APP_ENV === 'local' || APP_ENV === 'development');
?>

<!-- CSS Stylesheets -->
<?php if ($isDevelopment): ?>
<!-- Development: Individual CSS Files -->
<link href="/public/assets/css/_style.css" rel="stylesheet">
<link href="/public/assets/css/style.css" rel="stylesheet">
<link href="/public/assets/css/main_menu.css" rel="stylesheet">
<link href="/public/assets/css/main_layout.css" rel="stylesheet">
<link href="/public/assets/css/main_slide.css" rel="stylesheet">
<link href="/public/assets/css/brandstory.css" rel="stylesheet">
<link href="/public/assets/css/sub_menu.css" rel="stylesheet">
<link href="/public/assets/css/product.css" rel="stylesheet">
<link href="/public/assets/css/manual.css" rel="stylesheet">
<link href="/public/assets/css/b2b.css" rel="stylesheet">
<link href="/public/assets/css/sitemap.css" rel="stylesheet">
<link href="/public/assets/css/tip.css" rel="stylesheet">
<link href="/public/assets/css/FAQ.css" rel="stylesheet">
<link href="/public/assets/css/freshield_menu.css" rel="stylesheet">
<link href="/public/assets/css/intro_slide.css" rel="stylesheet">
<link href="/public/assets/css/photo.css" rel="stylesheet">
<link href="/public/assets/css/ext-all.css" rel="stylesheet">
<link href="/public/assets/css/common.css" rel="stylesheet">
<?php else: ?>
<!-- Production: Minified & Bundled CSS -->
<link href="/public/assets/css/dist/layout.min.css" rel="stylesheet">
<link href="/public/assets/css/dist/theme.min.css" rel="stylesheet">
<link href="/public/assets/css/dist/components.min.css" rel="stylesheet">
<link href="/public/assets/css/dist/vendor.min.css" rel="stylesheet">
<?php endif; ?>

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Google Fonts -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Merienda:400,700&display=swap">

<!-- Core JavaScript Libraries -->
<script src="/public/assets/js/jquery.min.js"></script>
<script src="/public/assets/js/ext-jquery-adapter.js"></script>
<script src="/public/assets/js/ext-all-3.js"></script>
<script src="/public/assets/js/jquery.banner.js"></script>
<?php if ($isDevelopment): ?>
<!-- Development: Individual JS Files -->
<script src="/public/assets/js/common.js"></script>
<script src="/public/assets/js/active.js"></script>
<script src="/public/assets/js/nav.js"></script>
<script src="/public/assets/js/main_bn.js"></script>
<?php else: ?>
<!-- Production: Minified & Bundled JS -->
<script src="/public/assets/js/dist/main.min.js"></script>
<?php endif; ?>

<script>
// Language switcher utility
var lang_client = {};
var required_lang = {
    getHref: function(lang) {
        var href = window.location.href.split('?');
        var domain = href[0];
        var queryString = href[1];
        var decode = Ext.urlDecode(queryString);
        Ext.apply(decode, {lang: lang});
        return domain + '?' + Ext.urlEncode(decode);
    },
    change: function(lang) {
        var href = this.getHref(lang);
        document.location.href = href;
    }
};

// Banner initialization
$(function() {
    if ($("#INTRO_IMG_BOX").length) {
        $("#INTRO_IMG_BOX").jQBanner({
            nWidth: 980,
            nHeight: 745,
            nCount: 2,
            isActType: "left",
            nOrderNo: 1,
            isStartAct: "N",
            isStartDelay: "Y",
            nDelay: 5000,
            isBtnType: "img"
        });
    }

    // Dropdown menu functionality
    $("ul.sub").hide();
    $(".smenu_basic, .smenu_long").hover(
        function() {
            $("ul:not(:animated)", this).slideDown("fast");
        },
        function() {
            $("ul", this).slideUp("fast");
        }
    );
});
</script>

<style>
img {border:0; float:left;}
a:link, a:visited, a:hover, a:active {text-decoration: none;}
</style>

<?php if (isset($structuredData)): ?>
<!-- Structured Data (JSON-LD) -->
<script type="application/ld+json">
<?php echo json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
<?php endif; ?>

</head>
<body id="main">

<!--TOP 영역 시작-->
<div id="TOP">
<div id="TOPMENU">
    <div class="LOGO">
        <a href="<?php echo isset($is_english) && $is_english ? '/en_index.php' : '/index.php'; ?>">
            <img src="/public/assets/images/top_logo.png" alt="Freshield Logo" width="200" height="60">
        </a>
    </div>
    <div class="MENULIST">
        <?php if(isset($is_english) && $is_english): ?>
        <!-- English Menu -->
        <div class="MENU_EN">
            <ul class="oneMenu_EN">
                <li><a href="/public/pages/brandstory_en.php">BRAND</a></li>
                <li><a href="/public/pages/product_freshield_en.php">PRODUCTS</a>
                    <ul class="twoMenu_EN">
                        <li><a href="/public/pages/product_freshield_en.php">Vacuum sealers</a>
                            <ul class="threeMenu1_EN">
                                <li style="border-top:1px solid #E4E4E4; height:41px;">
                                    <a href="/public/pages/product_outdoor1_en.php">OUTDOOR</a>
                                </li>
                                 <li style="border-left:1px solid #E4E4E4; height:42px;">
                                    <a href="/public/pages/product_advance_en.php">ADVANCE</a>
                                </li>
                                <li style="border-left:1px solid #E4E4E4; height:42px;border-bottom:1px solid #E4E4E4;">
                                    <a href="/public/pages/product_elite_en.php">ELITE</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/public/pages/product_genisys_en.php">Canisters</a>
                            <ul class="threeMenu2_EN">
                                <li style="border-top:1px solid #E4E4E4;  height:43px;">
                                    <a href="/public/pages/product_genisys_en.php">GENISYS</a>
                                </li>
                                <li style="border-left:1px solid #E4E4E4; border-bottom:1px solid #E4E4E4; height:42px;">
                                    <a href="/public/pages/product_handpump_en.php">HAND PUMP</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/public/pages/product_rollbag_en.php">Rolls &amp; Bags</a>
                            <ul class="threeMenu3_EN">
                                <li style="border-top:1px solid #E4E4E4; height:42px;">
                                    <a href="/public/pages/product_rollbag_en.php">Rolls &amp; Bags</a>
                                </li>
                                <li style="border-bottom:1px solid #E4E4E4; border-left:1px solid #E4E4E4; height:42px;">
                                    <a href="#">Wizvac Plus</a>
                                </li>
                            </ul>
                        </li>
                      </ul>
                </li>
                <li><a href="/public/pages/tip_en.php">TIPS</a></li>
                <li><a href="/public/pages/faq_en.php">SUPPORT</a>
                    <ul class="twoMenu_EN">
                        <li><a href="/public/pages/faq_en.php">FAQ</a></li>
                        <li><a href="/public/pages/manual_en.php">Downloads</a></li>
                    </ul>
                </li>
                <li><a href="/public/pages/contact_en.php">CONTACT</a></li>
                <li><a href="#">LANGUAGE</a>
                    <ul class="twoMenu_EN">
                        <li><a href="/index.php">한국어</a></li>
                        <li><a href="/en_index.php">ENGLISH</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php else: ?>
        <!-- Korean Menu -->
        <div class="MENU">
            <ul class="oneMenu">
                <li><a href="/public/pages/brandstory.php">브랜드</a>
                    <ul class="twoMenu">
                        <li><a href="/public/pages/brandstory.php">브랜드소개</a></li>
                        <li><a href="/public/pages/certification.php">인증현황</a></li>
                    </ul>
                </li>
                <li><a href="/public/pages/product_freshield.php">후레쉴드</a>
                    <ul class="twoMenu">
                        <li><a href="/public/pages/product_freshield.php">진공포장기</a>
                            <ul class="threeMenu1">
                                <li style="border-top:1px solid #E4E4E4; height:42px;">
                                    <a href="/public/pages/product_outdoor4.php">아웃도어</a>
                                </li>
                                 <li style="border-left:1px solid #E4E4E4; height:42px;">
                                    <a href="/public/pages/product_advance.php">어드밴스</a>
                                </li>
                                <li style="border-left:1px solid #E4E4E4; height:42px;border-bottom:1px solid #E4E4E4;">
                                    <a href="/public/pages/product_elite.php">엘리트</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/public/pages/product_genisys.php">진공용기</a>
                            <ul class="threeMenu2">
                                <li style="border-top:1px solid #E4E4E4;  height:43px;">
                                    <a href="/public/pages/product_genisys.php">제니시스</a>
                                </li>
                                <li style="border-left:1px solid #E4E4E4; border-bottom:1px solid #E4E4E4; height:42px;">
                                    <a href="/public/pages/product_handpump.php">핸드펌프</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/public/pages/product_rollbag.php">롤＆백</a>
                            <ul class="threeMenu3">
                                <li style="border-top:1px solid #E4E4E4; height:42px;">
                                    <a href="/public/pages/product_rollbag.php">롤＆백</a>
                                </li>
                                <li style="border-bottom:1px solid #E4E4E4; border-left:1px solid #E4E4E4; height:42px;">
                                    <a href="#">위즈백 플러스</a>
                                </li>
                            </ul>
                        </li>
                      </ul>
                </li>
                <li><a href="/public/pages/tip.php">활용 TIP</a></li>
                <li><a href="/public/pages/faq.php">고객지원</a>
                    <ul class="twoMenu">
                        <li><a href="/public/pages/faq.php">FAQ</a></li>
                        <li><a href="/public/pages/manual.php">자료실</a></li>
                    </ul>
                </li>
                <li><a href="/public/pages/contact.php">문의하기</a></li>
                <li><a href="#">언어선택</a>
                    <ul class="twoMenu">
                        <li><a href="/index.php">한국어</a></li>
                        <li><a href="/en_index.php">ENGLISH</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
</div>
<!--TOP 영역 끝-->
