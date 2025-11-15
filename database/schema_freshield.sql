-- ============================================================================
-- Freshield.com Database Schema
-- Version: 1.0
-- Created: Phase 2
-- Purpose: Complete database schema for Freshield vacuum sealer website
-- Database Engine: MySQL 5.7+ / MariaDB 10.3+
-- Character Set: utf8mb4 (for full Unicode support including emojis)
-- ============================================================================

-- Set character set and collation
SET NAMES utf8mb4;
SET CHARACTER_SET_CLIENT = utf8mb4;
SET CHARACTER_SET_CONNECTION = utf8mb4;

-- ============================================================================
-- DROP EXISTING TABLES (in reverse dependency order)
-- ============================================================================

DROP TABLE IF EXISTS `inquiries`;
DROP TABLE IF EXISTS `notices`;
DROP TABLE IF EXISTS `manuals`;
DROP TABLE IF EXISTS `faqs`;
DROP TABLE IF EXISTS `admins`;

-- ============================================================================
-- TABLE: admins
-- Purpose: Store admin user accounts for future admin panel (Phase 3)
-- ============================================================================

CREATE TABLE `admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` ENUM('superadmin', 'admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Admin users for backend management';

-- ============================================================================
-- TABLE: faqs
-- Purpose: Store FAQ entries in both Korean and English
-- ============================================================================

CREATE TABLE `faqs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `language` ENUM('ko', 'en') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `question` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_language_active` (`language`, `is_active`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='FAQ entries for customer support';

-- ============================================================================
-- TABLE: manuals
-- Purpose: Store downloadable manuals and documents in both languages
-- ============================================================================

CREATE TABLE `manuals` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `language` ENUM('ko', 'en') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `file_path` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` INT UNSIGNED NULL DEFAULT NULL COMMENT 'File size in bytes',
  `download_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_language_active` (`language`, `is_active`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Downloadable manuals and documents';

-- ============================================================================
-- TABLE: notices
-- Purpose: Store news and notice board entries for future use
-- ============================================================================

CREATE TABLE `notices` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `language` ENUM('ko', 'en') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_language_active` (`language`, `is_active`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='News and notice board entries';

-- ============================================================================
-- TABLE: inquiries
-- Purpose: Store customer contact form submissions for future use
-- ============================================================================

CREATE TABLE `inquiries` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `company` VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `product` VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `message` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` ENUM('new', 'pending', 'resolved', 'closed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Customer inquiry submissions';

-- ============================================================================
-- SCHEMA COMPLETE
-- ============================================================================

-- Notes:
-- 1. All tables use utf8mb4 for full Unicode support
-- 2. InnoDB engine for ACID compliance and foreign key support
-- 3. Indexes added for common query patterns
-- 4. is_active flags allow soft deletion
-- 5. sort_order fields enable manual ordering in admin panel
-- 6. Timestamps track creation and updates
-- 7. Schema is ready for Phase 3 admin panel implementation
