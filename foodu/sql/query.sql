 -- april 25,2022

ALTER TABLE `abserve_food_categories` CHANGE `type` `type` ENUM('category','brand','variation') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'category';

-- april 27,2022

ALTER TABLE `abserve_hotel_items` ADD `unit` TEXT NOT NULL AFTER `del_status`;

-- april 30,2022

ALTER TABLE `abserve_user_cart` ADD `unit` INT(11) NOT NULL DEFAULT '0' AFTER `wallet`;

--may 5,2022

ALTER TABLE `abserve_api_settings` ADD `fund_return_type` ENUM('wallet','refund') NOT NULL AFTER `promo_mode`;


--may 11,2022

ALTER TABLE `tb_users` ADD `location` INT(20) NOT NULL AFTER `services`;


DELETE FROM `tb_groups` WHERE `tb_groups`.`group_id` = 6;
DELETE FROM `tb_groups` WHERE `tb_groups`.`group_id` = 7;
DELETE FROM `tb_groups` WHERE `tb_groups`.`group_id` = 8;

UPDATE `tb_groups` SET `name` = 'Delivery Boy' WHERE `tb_groups`.`group_id` = 5;

UPDATE `tb_groups` SET `description` = 'Delivery Boy Level No 5' WHERE `tb_groups`.`group_id` = 5;

ALTER TABLE `tb_groups` auto_increment = 6;

ALTER TABLE `tb_users` ADD `latitude` DOUBLE NOT NULL AFTER `location`, ADD `longitude` DOUBLE NOT NULL AFTER `latitude`, ADD `bike` ENUM('yes','no') NULL DEFAULT NULL AFTER `longitude`, ADD `license` VARCHAR(100) NOT NULL DEFAULT '0' AFTER `bike`;

--may 16,2022

ALTER TABLE `tb_users` ADD `boy_status` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `active`, ADD `mode` ENUM('online','offline') NOT NULL DEFAULT 'online' AFTER `boy_status`;

--may 18,2022 

ALTER TABLE `tb_users` ADD `log_status` ENUM('login','logout','register','sociallogin','') NOT NULL DEFAULT '' AFTER `login_attempt`;

ALTER TABLE `tb_users` CHANGE `device` `device` ENUM('android','ios','web') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'web';

--may 20,2022

ALTER TABLE `abserve_hotel_items` CHANGE `status` `status` ENUM('active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'inactive';


--may 23,2022 C

ALTER TABLE `abserve_hotel_items` CHANGE `available_from` `start_time1` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `abserve_hotel_items` CHANGE `available_to` `end_time1` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `abserve_hotel_items` CHANGE `available_from2` `start_time2` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `abserve_hotel_items` CHANGE `available_to2` `end_time2` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


ALTER TABLE `abserve_hotel_items` CHANGE `start_time1` `start_time1` TIME NULL DEFAULT '00:00:00';
ALTER TABLE `abserve_hotel_items` CHANGE `end_time1` `end_time1` TIME NULL DEFAULT '00:00:00';
ALTER TABLE `abserve_hotel_items` CHANGE `start_time2` `start_time2` TIME NULL DEFAULT '00:00:00';
ALTER TABLE `abserve_hotel_items` CHANGE `end_time2` `end_time2` TIME NULL DEFAULT '00:00:00';


ALTER TABLE `abserve_addons` CHANGE `user_id` `user_id` BIGINT(20) NULL;

ALTER TABLE `abserve_addons` CHANGE `entry_by` `entry_by` INT(11) NULL;

ALTER TABLE `abserve_addons` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `abserve_addons` CHANGE `updated_at` `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;


--may 24,2022

ALTER TABLE `abserve_hotel_items` ADD `addon` INT(20) NOT NULL AFTER `item_status`;

ALTER TABLE `abserve_hotel_items` CHANGE `addon` `addon` VARCHAR(20) NOT NULL;


--apr 1, 2023 -- keerthi

ALTER TABLE `abserve_charge_settings` ADD `location` INT(20) NOT NULL DEFAULT '0' AFTER `status`;




ALTER TABLE `abserve_order_details` ADD `refund_reason` TEXT NULL DEFAULT NULL AFTER `refund_status`, ADD `refund_image` JSON NULL DEFAULT NULL AFTER `refund_reason`;

ALTER TABLE `abserve_order_details` ADD `refund_comment` TEXT NULL AFTER `refund_reason`;


ALTER TABLE `abserve_order_details` ADD `refund_amount` DECIMAL(20,2) NOT NULL DEFAULT '0.00' AFTER `refund_order`;


CREATE TABLE `abserve_del_boy_wallet` (
  `id` int(11) NOT NULL,
  `del_boy_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `transac_through` varchar(50) DEFAULT NULL,
  `transaction_amount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `trans_date` date NOT NULL,
  `transaction_type` enum('credit','debit') NOT NULL,
  `transaction_status` enum('0','1') NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abserve_del_boy_wallet`
--
ALTER TABLE `abserve_del_boy_wallet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abserve_del_boy_wallet`
--
ALTER TABLE `abserve_del_boy_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



  ALTER TABLE `abserve_del_boy_wallet` ADD `title` VARCHAR(255) NULL AFTER `created_at`, ADD `added_by` INT NULL AFTER `title`;
  ALTER TABLE `abserve_partner_wallet` ADD `title` VARCHAR(255) NULL AFTER `updated_at`, ADD `added_by` INT NULL AFTER `title`;
  

  ALTER TABLE `abserve_partner_wallet` ADD `payout_trans_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `trans_date`;

  