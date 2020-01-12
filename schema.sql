CREATE DATABASE IF NOT EXISTS task_force;

USE task_force;

CREATE TABLE IF NOT EXISTS `users` (
	`id`         INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`email`      VARCHAR(255)          NOT NULL                UNIQUE,
	`password`   VARCHAR(255)          NOT NULL,
	`name`       VARCHAR(255)          NOT NULL,
	`city`       VARCHAR(255)          NOT NULL,
	`avatar`     VARCHAR(255)          DEFAULT NULL,
	`about`      TEXT                  DEFAULT NULL,
	`birthday`   DATETIME              DEFAULT NULL,
	`phone`      TINYINT(4)   UNSIGNED DEFAULT NULL,
	`skype`      VARCHAR(255)          DEFAULT NULL,
	`messenger`  VARCHAR(255)          DEFAULT NULL,
	`created_at` DATETIME              NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `user_fail_counters` (
	`user_id`    INT(11) UNSIGNED NOT NULL           PRIMARY KEY,
	`counter`    INT(11) UNSIGNED NOT NULL DEFAULT 0,
	`created_at` DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_at` DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB
 DEFAULT CHARSET = utf8
 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `cities` (
	`id`        INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name`      VARCHAR(255)          NOT NULL                UNIQUE,
	`latitude`  FLOAT        UNSIGNED NOT NULL,
	`longitude` FLOAT        UNSIGNED NOT NULL
) ENGINE = InnoDB
 DEFAULT CHARSET = utf8mb4
 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `available_specializations` (
	`specialization_id` INT(11)      UNSIGNED NOT NULL PRIMARY KEY,
	`name`              VARCHAR(255)          NOT NULL UNIQUE,
	`created_at`        DATETIME              NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
	DEFAULT CHARSET = utf8
	COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `executor_specializations` (
	`user_id`           INT(11)  UNSIGNED NOT NULL PRIMARY KEY,
	`specialization_id` INT(11)  UNSIGNED NOT NULL,
	`created_at`        DATETIME          NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
 DEFAULT CHARSET = utf8
 COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `tasks` (
	`id`          INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`todo`        TEXT                  NOT NULL,
	`description` TEXT                  NOT NULL,
	`category`    INT(11)      UNSIGNED NOT NULL,
	`location`    VARCHAR(255)          DEFAULT NULL,
	`budget`      BIGINT(20)   UNSIGNED DEFAULT NULL,
	`expires_at`  DATETIME              NOT NULL,
	`status`      VARCHAR(255)          NOT NULL DEFAULT 'new',
	`customer_id` INT(11)      UNSIGNED NOT NULL,
	`executor_id` INT(11)      UNSIGNED NOT NULL,
	`category_id` INT(11)      UNSIGNED NOT NULL,
	`created_at`  DATETIME              NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `task_files` (
	`task_id`     INT(11)      UNSIGNED NOT NULL PRIMARY KEY,
	`source`      VARCHAR(255)          NOT NULL,
	`created_at`  DATETIME              NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `executor_responses` (
	`executor_id` INT(11) UNSIGNED NOT NULL,
	`task_id`     INT(11) UNSIGNED NOT NULL,
	`comment`     TEXT             NOT NULL,
	`price`       INT(11) UNSIGNED NOT NULL,
	`created_at`  DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (executor_id, task_id)
) ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `reviews` (
	`id`          INT(11)   UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`user_id`     INT(11)   UNSIGNED NOT NULL,
	`reviewer_id` INT(11)   UNSIGNED NOT NULL,
	`value`       TINYINT(1)         NOT NULL,
	`comment`     TEXT               NOT NULL,
	`created_at`  DATETIME           NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `chats` (
	`id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`chat_id`     INT(11) UNSIGNED NOT NULL,
	`executor_id` INT(11) UNSIGNED NOT NULL,
	`customer_id` INT(11) UNSIGNED NOT NULL,
	`message`     TEXT             NOT NULL,
	`created_at`  DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `categories` (
	`id`         INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name`       VARCHAR(255)          NOT NULL,
	`icon`       VARCHAR(255)          NOT NULL,
	`created_at` DATETIME              NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
	DEFAULT CHARSET = utf8mb4
	COLLATE = utf8mb4_unicode_ci;
