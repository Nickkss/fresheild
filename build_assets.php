<?php
/**
 * Freshield Asset Builder
 * Creates minified CSS and JS files for production
 *
 * Run this script after making changes to CSS/JS files:
 * php build_assets.php
 */

// Simple CSS minifier
function minifyCSS($css) {
    // Remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // Remove whitespace
    $css = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $css);
    // Remove spaces around selectors and properties
    $css = preg_replace('/\s*([{}|:;,])\s+/', '$1', $css);
    $css = preg_replace('/\s+/', ' ', $css);
    $css = preg_replace('/;}/', '}', $css);
    return trim($css);
}

// Simple JS minifier
function minifyJS($js) {
    // Remove comments
    $js = preg_replace('!/\*.*?\*/!s', '', $js);
    $js = preg_replace('/\/\/.*?[\r\n]/', "\n", $js);
    // Remove whitespace
    $js = preg_replace('/\s+/', ' ', $js);
    return trim($js);
}

// CSS files to combine and minify
$cssFiles = [
    'layout' => [
        'public/assets/css/_style.css',
        'public/assets/css/style.css',
        'public/assets/css/main_layout.css',
    ],
    'theme' => [
        'public/assets/css/main_menu.css',
        'public/assets/css/sub_menu.css',
        'public/assets/css/freshield_menu.css',
    ],
    'components' => [
        'public/assets/css/main_slide.css',
        'public/assets/css/intro_slide.css',
        'public/assets/css/product.css',
        'public/assets/css/manual.css',
        'public/assets/css/FAQ.css',
        'public/assets/css/tip.css',
        'public/assets/css/b2b.css',
        'public/assets/css/sitemap.css',
        'public/assets/css/brandstory.css',
        'public/assets/css/photo.css',
    ],
    'vendor' => [
        'public/assets/css/common.css',
        'public/assets/css/ext-all.css',
    ]
];

// JS files to combine and minify (excluding already minified files)
$jsFiles = [
    'main' => [
        'public/assets/js/common.js',
        'public/assets/js/active.js',
        'public/assets/js/nav.js',
        'public/assets/js/main_bn.js',
    ]
];

echo "Freshield Asset Builder\n";
echo "=======================\n\n";

// Build CSS files
foreach ($cssFiles as $name => $files) {
    $combined = '';
    echo "Building CSS: $name.min.css\n";

    foreach ($files as $file) {
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $combined .= "/* $file */\n" . $content . "\n\n";
            echo "  + Added: $file\n";
        } else {
            echo "  - Missing: $file\n";
        }
    }

    $minified = minifyCSS($combined);
    $outputFile = "public/assets/css/dist/{$name}.min.css";
    file_put_contents($outputFile, $minified);

    $originalSize = strlen($combined);
    $minifiedSize = strlen($minified);
    $savings = round((($originalSize - $minifiedSize) / $originalSize) * 100, 2);

    echo "  → Saved: $outputFile\n";
    echo "  → Size: " . number_format($originalSize) . " → " . number_format($minifiedSize) . " bytes ($savings% reduction)\n\n";
}

// Build JS files
foreach ($jsFiles as $name => $files) {
    $combined = '';
    echo "Building JS: $name.min.js\n";

    foreach ($files as $file) {
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $combined .= "/* $file */\n" . $content . "\n\n";
            echo "  + Added: $file\n";
        } else {
            echo "  - Missing: $file\n";
        }
    }

    $minified = minifyJS($combined);
    $outputFile = "public/assets/js/dist/{$name}.min.js";
    file_put_contents($outputFile, $minified);

    $originalSize = strlen($combined);
    $minifiedSize = strlen($minified);
    $savings = round((($originalSize - $minifiedSize) / $originalSize) * 100, 2);

    echo "  → Saved: $outputFile\n";
    echo "  → Size: " . number_format($originalSize) . " → " . number_format($minifiedSize) . " bytes ($savings% reduction)\n\n";
}

echo "=======================\n";
echo "Asset build complete!\n";
echo "\nNext steps:\n";
echo "1. Test minified assets on local server\n";
echo "2. Update config.php to set APP_ENV='production'\n";
echo "3. Minified assets will be used automatically\n";
?>
