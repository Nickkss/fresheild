-- ============================================================================
-- Freshield.com Sample Data
-- Version: 1.0
-- Created: Phase 2
-- Purpose: Sample data for testing FAQ and Manual functionality
-- ============================================================================

SET NAMES utf8mb4;
SET CHARACTER_SET_CLIENT = utf8mb4;
SET CHARACTER_SET_CONNECTION = utf8mb4;

-- ============================================================================
-- SAMPLE FAQ ENTRIES - KOREAN (language='ko')
-- ============================================================================

INSERT INTO `faqs` (`language`, `category`, `question`, `answer`, `sort_order`, `is_active`) VALUES
('ko', '제품사용', '진공포장기는 어떻게 사용하나요?', '진공포장기 사용법은 매우 간단합니다. 먼저 식품을 전용 백에 넣고, 백의 입구를 기기에 삽입한 후 뚜껑을 닫으면 자동으로 진공 및 밀봉이 진행됩니다. 자세한 사용법은 제품 사용설명서를 참조하시거나 자료실에서 매뉴얼을 다운로드 받으시기 바랍니다.', 1, 1),

('ko', '제품사용', '어떤 종류의 식품을 진공포장할 수 있나요?', '대부분의 식품을 진공포장할 수 있습니다. 육류, 생선, 채소, 과일, 치즈, 견과류 등 다양한 식품의 신선도를 오래 유지할 수 있습니다. 다만 무른 과일이나 빵 등 눌릴 수 있는 식품은 주의가 필요하며, 액체가 많은 식품은 냉동 후 포장하시는 것을 권장합니다.', 2, 1),

('ko', '유지관리', '진공포장기 청소는 어떻게 하나요?', '사용 후 진공 챔버와 실링 바(밀봉부)를 부드러운 천으로 닦아주시고, 물기가 있다면 완전히 건조시켜 주세요. 진공펌프 부분은 물이 들어가지 않도록 주의하시고, 외부는 젖은 천으로 가볍게 닦아주시면 됩니다. 정기적인 청소로 제품 수명을 연장할 수 있습니다.', 3, 1),

('ko', '문제해결', '진공이 제대로 되지 않을 때는 어떻게 하나요?', '진공이 제대로 되지 않는 경우 다음을 확인해주세요: 1) 백의 입구가 올바르게 삽입되었는지 확인 2) 백에 구멍이나 손상이 없는지 확인 3) 실링 바가 깨끗한지 확인 4) 뚜껑이 완전히 닫혔는지 확인. 그래도 문제가 해결되지 않으면 고객센터로 문의해 주세요.', 4, 1),

('ko', 'A/S', '제품 보증기간은 얼마나 되나요?', '후레쉴드 진공포장기는 구매일로부터 1년간 무상 보증이 제공됩니다. 보증기간 내 정상적인 사용 중 발생한 제품 결함은 무상으로 수리 또는 교환해 드립니다. 단, 사용자 과실이나 천재지변으로 인한 손상은 보증 대상에서 제외됩니다. A/S 문의는 고객센터 031-488-7777로 연락주시기 바랍니다.', 5, 1),

('ko', '제품선택', '후레쉴드 제품 라인업의 차이점은 무엇인가요?', '후레쉴드는 다양한 라인업을 제공합니다. OUTDOOR 모델은 휴대가 간편하고 캠핑에 최적화되어 있으며, ADVANCE는 중급 사용자를 위한 다양한 기능을 제공합니다. ELITE는 프리미엄 모델로 강력한 진공력과 고급 기능을 갖추고 있습니다. 용도와 예산에 맞춰 선택하시면 됩니다.', 6, 1),

('ko', '제품사용', '진공용기(캐니스터)는 어떻게 사용하나요?', '진공용기 사용법: 1) 식품을 용기에 담고 뚜껑을 닫습니다 2) 진공호스를 포장기와 용기 밸브에 연결합니다 3) 진공 버튼을 눌러 공기를 제거합니다 4) 진공이 완료되면 호스를 분리합니다. 용기는 냉장고에 보관하면 신선도가 더욱 오래 유지됩니다.', 7, 1);

-- ============================================================================
-- SAMPLE FAQ ENTRIES - ENGLISH (language='en')
-- ============================================================================

INSERT INTO `faqs` (`language`, `category`, `question`, `answer`, `sort_order`, `is_active`) VALUES
('en', 'Product Usage', 'How do I use the vacuum sealer?', 'Using the vacuum sealer is very simple. First, place your food in a dedicated bag, insert the opening of the bag into the machine, and close the lid. The vacuum and sealing process will start automatically. For detailed instructions, please refer to the product manual or download it from our Downloads section.', 1, 1),

('en', 'Product Usage', 'What types of food can I vacuum pack?', 'You can vacuum pack most types of food including meat, fish, vegetables, fruits, cheese, and nuts to maintain their freshness longer. However, please be careful with soft fruits or bread that can be crushed. For foods with high liquid content, we recommend freezing them before packing.', 2, 1),

('en', 'Maintenance', 'How do I clean the vacuum sealer?', 'After use, wipe the vacuum chamber and sealing bar with a soft cloth. If there is any moisture, make sure to dry it completely. Be careful not to let water enter the vacuum pump area. The exterior can be wiped with a damp cloth. Regular cleaning will extend the product lifespan.', 3, 1),

('en', 'Troubleshooting', 'What should I do if the vacuum is not working properly?', 'If the vacuum is not working properly, please check the following: 1) Verify the bag opening is inserted correctly 2) Check for holes or damage in the bag 3) Ensure the sealing bar is clean 4) Confirm the lid is completely closed. If the problem persists, please contact our customer service.', 4, 1),

('en', 'Warranty', 'What is the product warranty period?', 'Freshield vacuum sealers come with a 1-year warranty from the date of purchase. Product defects that occur during normal use within the warranty period will be repaired or replaced free of charge. However, damage caused by user negligence or natural disasters is excluded from warranty coverage. For A/S inquiries, please contact our customer service at +82-31-488-7777.', 5, 1),

('en', 'Product Selection', 'What are the differences between Freshield product lines?', 'Freshield offers various product lines. The OUTDOOR model is portable and optimized for camping. ADVANCE provides various features for intermediate users. ELITE is our premium model with powerful vacuum strength and advanced features. Please choose according to your needs and budget.', 6, 1),

('en', 'Product Usage', 'How do I use vacuum canisters?', 'Canister usage: 1) Put food in the container and close the lid 2) Connect the vacuum hose to both the machine and container valve 3) Press the vacuum button to remove air 4) Once vacuum is complete, disconnect the hose. Store the container in the refrigerator to maintain freshness even longer.', 7, 1);

-- ============================================================================
-- SAMPLE MANUAL ENTRIES - KOREAN (language='ko')
-- ============================================================================

INSERT INTO `manuals` (`language`, `category`, `title`, `description`, `file_path`, `file_size`, `sort_order`, `is_active`) VALUES
('ko', '사용설명서', '후레쉴드 ELITE 사용설명서', 'ELITE 모델의 전체 기능과 사용법을 상세히 설명한 공식 사용설명서입니다.', '/uploads/manuals/freshield_elite_manual_ko.pdf', 2458624, 1, 1),

('ko', '사용설명서', '후레쉴드 ADVANCE 사용설명서', 'ADVANCE 모델의 설치, 사용, 유지관리 방법이 담긴 사용설명서입니다.', '/uploads/manuals/freshield_advance_manual_ko.pdf', 1895424, 2, 1),

('ko', '사용설명서', '후레쉴드 OUTDOOR 사용설명서', '휴대용 OUTDOOR 모델의 간편 사용법과 캠핑 활용 팁이 포함된 설명서입니다.', '/uploads/manuals/freshield_outdoor_manual_ko.pdf', 1234567, 3, 1),

('ko', '제품카탈로그', '2025 후레쉴드 제품 카탈로그', '전체 제품 라인업과 사양을 한눈에 볼 수 있는 종합 카탈로그입니다.', '/uploads/manuals/freshield_catalog_2025_ko.pdf', 5234567, 4, 1),

('ko', '활용가이드', '진공포장 식품 보관 가이드', '식품별 최적의 진공포장 방법과 보관 기간을 안내하는 가이드북입니다.', '/uploads/manuals/freshield_food_storage_guide_ko.pdf', 987654, 5, 1),

('ko', '제품카탈로그', '진공용기(캐니스터) 제품군 소개', 'GENISYS 진공용기 시리즈의 상세 사양과 활용법을 담은 자료입니다.', '/uploads/manuals/freshield_canister_catalog_ko.pdf', 1456789, 6, 1),

('ko', '기술자료', '진공포장 기술의 과학적 원리', '진공포장이 식품 보존에 효과적인 이유를 과학적으로 설명한 기술 자료입니다.', '/uploads/manuals/freshield_vacuum_science_ko.pdf', 2345678, 7, 1);

-- ============================================================================
-- SAMPLE MANUAL ENTRIES - ENGLISH (language='en')
-- ============================================================================

INSERT INTO `manuals` (`language`, `category`, `title`, `description`, `file_path`, `file_size`, `sort_order`, `is_active`) VALUES
('en', 'User Manual', 'Freshield ELITE User Manual', 'Official user manual with detailed instructions for all ELITE model functions and usage.', '/uploads/manuals/freshield_elite_manual_en.pdf', 2356789, 1, 1),

('en', 'User Manual', 'Freshield ADVANCE User Manual', 'User manual containing installation, usage, and maintenance instructions for the ADVANCE model.', '/uploads/manuals/freshield_advance_manual_en.pdf', 1823456, 2, 1),

('en', 'User Manual', 'Freshield OUTDOOR User Manual', 'Manual for the portable OUTDOOR model with simple usage instructions and camping tips.', '/uploads/manuals/freshield_outdoor_manual_en.pdf', 1198765, 3, 1),

('en', 'Product Catalog', '2025 Freshield Product Catalog', 'Comprehensive catalog showcasing the complete product lineup and specifications.', '/uploads/manuals/freshield_catalog_2025_en.pdf', 5123456, 4, 1),

('en', 'Usage Guide', 'Vacuum Sealed Food Storage Guide', 'Guidebook providing optimal vacuum packing methods and storage periods for different foods.', '/uploads/manuals/freshield_food_storage_guide_en.pdf', 956789, 5, 1),

('en', 'Product Catalog', 'Vacuum Canister Product Line Introduction', 'Detailed specifications and usage methods for the GENISYS vacuum canister series.', '/uploads/manuals/freshield_canister_catalog_en.pdf', 1423456, 6, 1),

('en', 'Technical Document', 'The Science of Vacuum Packaging', 'Technical document explaining the scientific principles behind vacuum packaging for food preservation.', '/uploads/manuals/freshield_vacuum_science_en.pdf', 2287654, 7, 1);

-- ============================================================================
-- SAMPLE DATA COMPLETE
-- ============================================================================

-- Summary:
-- - 7 Korean FAQ entries
-- - 7 English FAQ entries
-- - 7 Korean Manual entries
-- - 7 English Manual entries
-- Total: 28 sample records

-- Note: File paths are placeholders. In production, these would point to actual
-- uploaded PDF files. The admin panel (Phase 3) will handle file uploads.
