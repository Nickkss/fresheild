-- ============================================================================
-- FRESHIELD DATABASE - PHASE 4 ADDITIONS
-- ============================================================================
-- Purpose: Add security and contact form enhancements
-- Date: November 15, 2025
-- ============================================================================

USE freshield_db;

-- ============================================================================
-- Admin Login Activity Logging Table
-- ============================================================================
-- Tracks all login attempts (successful and failed) for security auditing

CREATE TABLE IF NOT EXISTS `admin_logins` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `admin_id` INT UNSIGNED NULL,
    `username` VARCHAR(50) NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `user_agent` VARCHAR(255) NULL,
    `status` ENUM('success', 'failed', 'blocked') NOT NULL,
    `failure_reason` VARCHAR(255) NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    INDEX `idx_admin_id` (`admin_id`),
    INDEX `idx_username` (`username`),
    INDEX `idx_ip_address` (`ip_address`),
    INDEX `idx_status` (`status`),
    INDEX `idx_created_at` (`created_at`),
    INDEX `idx_ip_created` (`ip_address`, `created_at`),

    FOREIGN KEY (`admin_id`) REFERENCES `admins`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Verify Inquiries Table (should exist from Phase 2)
-- ============================================================================
-- If not exists, create it

CREATE TABLE IF NOT EXISTS `inquiries` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `company` VARCHAR(100) NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NULL,
    `product` VARCHAR(100) NULL,
    `message` TEXT NOT NULL,
    `status` ENUM('new', 'read', 'replied', 'archived') NOT NULL DEFAULT 'new',
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    INDEX `idx_status` (`status`),
    INDEX `idx_email` (`email`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Verify Notices Table (should exist from Phase 2)
-- ============================================================================
-- If not exists, create it

CREATE TABLE IF NOT EXISTS `notices` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `language` ENUM('ko', 'en') NOT NULL DEFAULT 'ko',
    `title` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `view_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    INDEX `idx_language` (`language`),
    INDEX `idx_is_active` (`is_active`),
    INDEX `idx_sort_order` (`sort_order`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Update Admin table to add login tracking fields
-- ============================================================================

ALTER TABLE `admins`
ADD COLUMN IF NOT EXISTS `last_login_at` DATETIME NULL,
ADD COLUMN IF NOT EXISTS `last_login_ip` VARCHAR(45) NULL,
ADD COLUMN IF NOT EXISTS `failed_login_count` INT UNSIGNED NOT NULL DEFAULT 0,
ADD COLUMN IF NOT EXISTS `locked_until` DATETIME NULL;

-- ============================================================================
-- Sample Notices (Optional - for testing)
-- ============================================================================

INSERT INTO `notices` (`language`, `title`, `body`, `sort_order`, `is_active`) VALUES
('ko', '후레쉴드 신제품 출시 안내', '새로운 아웃도어 진공포장기가 출시되었습니다. 더욱 강력한 성능과 휴대성을 자랑하는 신제품을 만나보세요.', 1, 1),
('ko', '고객지원 운영시간 안내', '고객지원은 평일 오전 9시부터 오후 6시까지 운영됩니다. 주말 및 공휴일은 휴무입니다.', 2, 1),
('en', 'New Product Launch', 'Our new Outdoor Vacuum Sealer has been launched. Experience more powerful performance and portability.', 1, 1),
('en', 'Customer Support Hours', 'Customer support is available from 9 AM to 6 PM on weekdays. Closed on weekends and holidays.', 2, 1)
ON DUPLICATE KEY UPDATE title=title;

-- ============================================================================
-- Verification Queries
-- ============================================================================

-- Check all tables exist
SELECT
    'Tables created successfully' AS status,
    COUNT(*) AS table_count
FROM information_schema.tables
WHERE table_schema = 'freshield_db'
AND table_name IN ('admin_logins', 'inquiries', 'notices', 'admins', 'faqs', 'manuals');

-- Show admin_logins structure
SHOW CREATE TABLE admin_logins;

-- ============================================================================
-- END OF PHASE 4 SCHEMA ADDITIONS
-- ============================================================================
