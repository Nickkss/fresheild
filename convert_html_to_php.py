import re
import os

# File mapping: source HTML file -> destination PHP file
files_to_convert = [
    # Korean Product Pages
    ("d:\\freshield.com\\product\\freshield.html", "d:\\freshield.com\\public\\pages\\product_freshield.php"),
    ("d:\\freshield.com\\product\\1outdoor.html", "d:\\freshield.com\\public\\pages\\product_outdoor1.php"),
    ("d:\\freshield.com\\product\\2outdoor.html", "d:\\freshield.com\\public\\pages\\product_outdoor2.php"),
    ("d:\\freshield.com\\product\\3advance.html", "d:\\freshield.com\\public\\pages\\product_advance.php"),
    ("d:\\freshield.com\\product\\4elite.html", "d:\\freshield.com\\public\\pages\\product_elite.php"),
    ("d:\\freshield.com\\product\\5genisys.html", "d:\\freshield.com\\public\\pages\\product_genisys.php"),
    ("d:\\freshield.com\\product\\6handpump.html", "d:\\freshield.com\\public\\pages\\product_handpump.php"),
    ("d:\\freshield.com\\product\\7rollbag.html", "d:\\freshield.com\\public\\pages\\product_rollbag.php"),

    # English Product Pages
    ("d:\\freshield.com\\product\\EN_freshield.html", "d:\\freshield.com\\public\\pages\\product_freshield_en.php"),
    ("d:\\freshield.com\\product\\EN_1outdoor.html", "d:\\freshield.com\\public\\pages\\product_outdoor1_en.php"),
    ("d:\\freshield.com\\product\\EN_2outdoor.html", "d:\\freshield.com\\public\\pages\\product_outdoor2_en.php"),
    ("d:\\freshield.com\\product\\EN_3advance.html", "d:\\freshield.com\\public\\pages\\product_advance_en.php"),
    ("d:\\freshield.com\\product\\EN_4elite.html", "d:\\freshield.com\\public\\pages\\product_elite_en.php"),
    ("d:\\freshield.com\\product\\EN_5genisys.html", "d:\\freshield.com\\public\\pages\\product_genisys_en.php"),
    ("d:\\freshield.com\\product\\EN_6handpump.html", "d:\\freshield.com\\public\\pages\\product_handpump_en.php"),
    ("d:\\freshield.com\\product\\EN_7rollbag.html", "d:\\freshield.com\\public\\pages\\product_rollbag_en.php"),

    # Brand Pages
    ("d:\\freshield.com\\introduction\\brandstory.html", "d:\\freshield.com\\public\\pages\\brandstory.php"),
    ("d:\\freshield.com\\introduction\\EN_brandstory.html", "d:\\freshield.com\\public\\pages\\brandstory_en.php"),
    ("d:\\freshield.com\\introduction\\certification.html", "d:\\freshield.com\\public\\pages\\certification.php"),

    # Support Pages
    ("d:\\freshield.com\\board\\FAQ.html", "d:\\freshield.com\\public\\pages\\faq.php"),
    ("d:\\freshield.com\\board\\EN_FAQ.html", "d:\\freshield.com\\public\\pages\\faq_en.php"),
    ("d:\\freshield.com\\board\\manual.html", "d:\\freshield.com\\public\\pages\\manual.php"),
    ("d:\\freshield.com\\board\\EN_manual.html", "d:\\freshield.com\\public\\pages\\manual_en.php"),

    # Other Pages
    ("d:\\freshield.com\\business\\b2b.html", "d:\\freshield.com\\public\\pages\\business.php"),
    ("d:\\freshield.com\\tip\\tip.html", "d:\\freshield.com\\public\\pages\\tip.php"),
    ("d:\\freshield.com\\tip\\EN_tip.html", "d:\\freshield.com\\public\\pages\\tip_en.php"),
    ("d:\\freshield.com\\sitemap\\sitemap.html", "d:\\freshield.com\\public\\pages\\sitemap.php"),
    ("d:\\freshield.com\\sitemap\\EN_sitemap.html", "d:\\freshield.com\\public\\pages\\sitemap_en.php"),
]

def extract_body_content(html_content):
    """Extract only the body content between header and footer"""
    # Find the end of TOP/header section
    header_patterns = [
        r'<!--TOP 영역 끝-->.*?</body>',
        r'<!-- top영역끝 -->',
        r'<!--top영역끝 -->',
    ]

    # Find the start of footer section
    footer_patterns = [
        r'<!--footer 영역-->',
        r'<!-- footer 영역-->',
        r'<!-- bottom 레이아웃 파일-->',
    ]

    # Find header end position
    header_end = 0
    for pattern in header_patterns:
        match = re.search(pattern, html_content, re.DOTALL | re.IGNORECASE)
        if match:
            header_end = match.end()
            break

    # Find footer start position
    footer_start = len(html_content)
    for pattern in footer_patterns:
        match = re.search(pattern, html_content, re.DOTALL | re.IGNORECASE)
        if match:
            footer_start = match.start()
            break

    # Extract content between header and footer
    if header_end > 0 and footer_start > header_end:
        body_content = html_content[header_end:footer_start]
    else:
        # Fallback: try to extract from first content div to footer
        body_content = html_content

    return body_content.strip()

def replace_paths(content):
    """Replace all asset paths to use /public/assets/..."""

    # Replace skin/default/images/ with /public/assets/images/
    content = re.sub(r'\.\.\/skin\/default\/images\/', '/public/assets/images/', content)
    content = re.sub(r'\/skin\/default\/images\/', '/public/assets/images/', content)
    content = re.sub(r'skin\/default\/images\/', '/public/assets/images/', content)

    # Replace skin/default/_images/ with /public/assets/images/
    content = re.sub(r'\.\.\/skin\/default\/_images\/', '/public/assets/images/', content)
    content = re.sub(r'\/skin\/default\/_images\/', '/public/assets/images/', content)
    content = re.sub(r'skin\/default\/_images\/', '/public/assets/images/', content)

    # Replace skin/default/css/ with /public/assets/css/
    content = re.sub(r'\.\.\/skin\/default\/css\/', '/public/assets/css/', content)
    content = re.sub(r'\/skin\/default\/css\/', '/public/assets/css/', content)
    content = re.sub(r'skin\/default\/css\/', '/public/assets/css/', content)

    # Replace skin/default/_css/ with /public/assets/css/
    content = re.sub(r'\.\.\/skin\/default\/_css\/', '/public/assets/css/', content)
    content = re.sub(r'\/skin\/default\/_css\/', '/public/assets/css/', content)
    content = re.sub(r'skin\/default\/_css\/', '/public/assets/css/', content)

    # Replace skin/default/js/ with /public/assets/js/
    content = re.sub(r'\.\.\/skin\/default\/js\/', '/public/assets/js/', content)
    content = re.sub(r'\/skin\/default\/js\/', '/public/assets/js/', content)
    content = re.sub(r'skin\/default\/js\/', '/public/assets/js/', content)

    # Replace skin/default/_js/ with /public/assets/js/
    content = re.sub(r'\.\.\/skin\/default\/_js\/', '/public/assets/js/', content)
    content = re.sub(r'\/skin\/default\/_js\/', '/public/assets/js/', content)
    content = re.sub(r'skin\/default\/_js\/', '/public/assets/js/', content)

    # Replace skin/_modules/talk/default/ with /public/assets/
    content = re.sub(r'\.\.\/skin\/_modules\/talk\/default\/', '/public/assets/', content)
    content = re.sub(r'\/skin\/_modules\/talk\/default\/', '/public/assets/', content)
    content = re.sub(r'skin\/_modules\/talk\/default\/', '/public/assets/', content)

    return content

def convert_file(source_path, dest_path):
    """Convert a single HTML file to PHP template"""
    try:
        # Read source file
        with open(source_path, 'r', encoding='utf-8') as f:
            html_content = f.read()

        # Extract body content
        body_content = extract_body_content(html_content)

        # Replace paths
        php_content = replace_paths(body_content)

        # Write to destination
        with open(dest_path, 'w', encoding='utf-8') as f:
            f.write(php_content)

        return True, None
    except Exception as e:
        return False, str(e)

# Main conversion process
def main():
    success_count = 0
    failed_files = []

    print("Starting HTML to PHP conversion...")
    print("=" * 80)

    for source_path, dest_path in files_to_convert:
        source_filename = os.path.basename(source_path)
        dest_filename = os.path.basename(dest_path)

        if not os.path.exists(source_path):
            print(f"SKIP: {source_filename} (source not found)")
            failed_files.append((source_filename, "Source file not found"))
            continue

        success, error = convert_file(source_path, dest_path)

        if success:
            print(f"OK: {source_filename} -> {dest_filename}")
            success_count += 1
        else:
            print(f"FAIL: {source_filename} - {error}")
            failed_files.append((source_filename, error))

    print("=" * 80)
    print(f"\nConversion Summary:")
    print(f"  Total files: {len(files_to_convert)}")
    print(f"  Successfully converted: {success_count}")
    print(f"  Failed: {len(failed_files)}")

    if failed_files:
        print("\nFailed files:")
        for filename, error in failed_files:
            print(f"  - {filename}: {error}")

    print("\nDone!")

if __name__ == "__main__":
    main()
