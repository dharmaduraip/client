ALTER TABLE `courses` ADD `other_cats` VARCHAR(255) NULL AFTER `country`;


ALTER TABLE `institute` ADD `slug` VARCHAR(255) NOT NULL AFTER `address`;
/* 10-10-2022  */ 



/*8-6-2023*/
ALTER TABLE `homesettings` ADD `institute_enable` TINYINT(1) NOT NULL DEFAULT '1' AFTER `newsletter_enable`;
ALTER TABLE `homesettings` ADD `get_enable` TINYINT(1) NOT NULL DEFAULT '1' AFTER `institute_enable`;
ALTER TABLE `homesettings` ADD `discount_badget_enable` TINYINT(1) NOT NULL DEFAULT '1' AFTER `get_enable`;


/*13.06.23*/
ALTER TABLE `settings` ADD `pesapal_ipn_id` VARCHAR(255) NULL DEFAULT NULL AFTER `stripe_enable`;
ALTER TABLE `settings` ADD `pesapal_token` TEXT NULL DEFAULT NULL AFTER `stripe_enable`;


/*14.06.23*/
ALTER TABLE `orders` ADD `pesapal_token` TEXT NULL DEFAULT NULL AFTER `transaction_id`;
ALTER TABLE `settings` ADD `pesapal_enable` VARCHAR(255) NOT NULL DEFAULT '0' AFTER `stripe_enable`;
ALTER TABLE `settings` ADD `OrderTrackingId` TEXT NULL DEFAULT NULL AFTER `pesapal_ipn_id`;

/* 17.06.23 */
ALTER TABLE `settings` ADD `africas_talking_enable` TINYINT(1) NOT NULL DEFAULT '0' AFTER `twilio_enable`;


-- INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('19', '2');
-- INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('19', '3');


/*19.06.23*/
ALTER TABLE `menus` ADD `position_menu` VARCHAR(255) NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `menus` ADD `top` VARCHAR(255) NULL DEFAULT NULL AFTER `position_menu`;
ALTER TABLE `menus` ADD `footer` VARCHAR(255) NULL DEFAULT NULL AFTER `top`;


/*21.06.23*/
ALTER TABLE `contacts` ADD `reason` TEXT NULL DEFAULT NULL AFTER `contacts`;

/*23.06.23*/
all state table last record delete


/*28.06.23*/
ALTER TABLE `quiz_answers` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `users` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;

/*29.06.23 */
ALTER TABLE `quiz_questions` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `subtitles` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;


/* 30-06-2023  */ 
ALTER TABLE `refund_courses` ADD `order_refund_id` INT NULL AFTER `order_id`;
ALTER TABLE `refund_courses` ADD `refunded_amt` DOUBLE NULL DEFAULT NULL AFTER `total_amount`;

-- 01-07-2023
ALTER TABLE `quiz_questions` ADD `e` VARCHAR(255) NULL DEFAULT NULL AFTER `d`;
ALTER TABLE `quiz_questions` ADD `anscnt` VARCHAR(255) NULL AFTER `position`;


-- 07-07-2023
ALTER TABLE `users` ADD `document_detail` TEXT NULL AFTER `age`;
ALTER TABLE `users` ADD `document_file` VARCHAR(255) NULL DEFAULT NULL AFTER `document_detail`;
ALTER TABLE `users` ADD `is_blocked` VARCHAR(255) NULL AFTER `document_file`;
ALTER TABLE `users` ADD `block_note` VARCHAR(255) NULL AFTER `is_blocked`;

ALTER TABLE `watch_courses` CHANGE `id` `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 17-07-23
ALTER TABLE `questions` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `question_reports` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `report_reviews` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `review_ratings` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `review_helpfuls` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 11-08-2023
ALTER TABLE `users` ADD `phone_code` VARCHAR(255) NULL DEFAULT NULL AFTER `doa`;

-- 21.08.23
ALTER TABLE `orders` ADD `merchant_reference` VARCHAR(255) NULL AFTER `order_id`;

-- 22.08.23
ALTER TABLE `users` ADD `iso_code` VARCHAR(255) NULL DEFAULT NULL AFTER `doa`;

-- 30.08.23
ALTER TABLE `course_progress` ADD `certificate_no` VARCHAR(255) NULL DEFAULT NULL AFTER `all_chapter_id`;
