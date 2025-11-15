import re

files = [
    "d:/freshield.com/public/pages/business.php",
    "d:/freshield.com/public/pages/manual.php",
    "d:/freshield.com/public/pages/manual_en.php",
]

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Fix the talk module paths
    content = re.sub(r'\.\.\/skin\/_modules\/talk\/default\/', '/public/assets/', content)

    # Fix the board module paths
    content = re.sub(r'\.\.\/skin\/_modules\/board\/default\/', '/public/assets/', content)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

    print(f"Fixed: {filepath}")

print("Done!")
