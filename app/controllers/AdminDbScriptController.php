<?php

class AdminDbScriptController extends \BaseController
{


	public function runaltertable()
	{
		try {
			DB::statement('alter table `coupons` add `campaign_type` varchar(255) null, add `campaign_logo` varchar(255) null');
			DB::statement('alter table `coupons` add `url_str` varchar(255) null');
			DB::statement("CREATE TABLE `settings` (
				`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				`logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
				`created_at` timestamp NULL DEFAULT NULL,
				`updated_at` timestamp NULL DEFAULT NULL,
				PRIMARY KEY (`id`) USING BTREE
			   ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}
	public function create_coupon_view()
	{
		try {
			DB::statement("
			CREATE VIEW `coupons_view` AS 
			select `c`.`id` AS `id`,`c`.`id` AS `coupon_id`,`c`.`name` AS `name`,`c`.`expires` AS `expires`,`c`.`receive_by` 
			AS `receive_by`,`c`.`coupon_type_id` AS `coupon_type_id`,`c`.`barcode` AS `barcode`,(case when (`c`.`active` <> 0) then 'Yes' else 'No' end) AS `active`,
			(case when (`c`.`campaign_type` is null) then 'Not Defined' else `c`.`campaign_type` end) AS `campaign_type`,(case when (`c`.`url_str` is null) then 'N/D' else `c`.`url_str` end)
			AS `campaign_url`,(case when (`c`.`campaign_logo` is null) then 'N/A' else `c`.`campaign_logo` end) 
			AS `campaign_logo`,concat(`u`.`first_name`,' ',`u`.`last_name`) AS `user`,`ct`.`name` 
			AS `coupon_type`,`b`.`name` AS `brand`,`c`.`created_at` AS `created_at`,`c`.`updated_at` AS `updated_at` 
			from (((`coupons` `c` join `brands` `b` on((`c`.`brand_id` = `b`.`id`))) join `coupon_types` `ct` on((`c`.`coupon_type_id` = `ct`.`id`))) join `users` `u` on((`c`.`user_id` = `u`.`id`)))
			");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function alter_coupon_table_cust_url()
	{
		try {
			DB::statement("alter table `coupons` add `custom_url` varchar(255) null");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function recreate_etreis_views()
	{
		try {
			DB::statement("
			CREATE OR REPLACE VIEW `entries_irc_view` AS select `e`.`id` AS `id`,`r`.`name` AS `retailer`,`r`.`state` 
			AS `retailer_state`,`c`.`name` AS `program`,`c`.`id` AS `coupon_id`,`ch`.`name` AS `clearinghouse`,(case when (`e`.`is_invoiced` <> 0) then 'Yes' else 'No' end) 
			AS `is_invoiced`,`e`.`coupon_quantity` AS `coupon_quantity`,(case when (`c`.`campaign_type` is null) then 'Not Defined' else `c`.`campaign_type` end) 
			AS `campaign_type`,(case when (`c`.`campaign_logo` is null) then 'N/A' else `c`.`campaign_logo` end) 
			AS `campaign_logo`,`e`.`payable` AS `payable`,`e`.`shipping` AS `shipping`,`u`.`id` 
			AS `client_id`,concat(`u`.`first_name`,' ',`u`.`last_name`) AS `client_name`,`b`.`name` 
			AS `brand`,`e`.`created_at` AS `created_at`,`e`.`updated_at` AS `updated_at`,`e`.`deleted_at` 
			AS `deleted_at` 
			from (((((`entries_irc` `e` left join `retailers` `r` on((`e`.`retailer_id` = `r`.`id`))) left join `coupons` `c` on((`e`.`coupon_id` = `c`.`id`))) left join `clearinghouses` `ch` on((`e`.`clearinghouse_id` = `ch`.`id`))) join `users` `u` on((`c`.`user_id` = `u`.`id`))) join `brands` `b` on((`c`.`brand_id` = `b`.`id`)))
			");

			DB::statement("
			CREATE OR REPLACE VIEW `entries_mir_view` AS select `e`.`id` AS `id`,`e`.`dollar_value` 
			AS `dollar_value`,`r`.`name` AS `retailer`,`c`.`name` AS `coupon`,`c`.`id` AS `coupon_id`,concat_ws(' ',`u`.`first_name`,`u`.`last_name`) 
			AS `owner`,`s`.`name` AS `status`,`e`.`first_name` AS `first_name`,`e`.`last_name` AS `last_name`,`e`.`address` 
			AS `address`,`e`.`city` AS `city`,`e`.`state` AS `state`,`e`.`zip` AS `zip`,(case when (`c`.`campaign_type` is null) then 'Not Defined' else `c`.`campaign_type` end) 
			AS `campaign_type`,(case when (`c`.`campaign_logo` is null) then 'N/A' else `c`.`campaign_logo` end) AS `campaign_logo`,`e`.`birth_date` AS `birth_date`,`e`.`invoiced_date` 
			AS `invoiced_date`,`dr`.`name` AS `denial_reason_id`,`e`.`created_at` AS `created_at` 
			from (((((`entries_mir` `e` left join `mir_retailers` `r` on((`e`.`mir_retailer_id` = `r`.`id`))) left join `coupons` `c` on((`e`.`coupon_id` = `c`.`id`))) left join `mir_statuses` `s` on((`e`.`mir_status_id` = `s`.`id`))) left join `mir_denial_reasons` `dr` on((`e`.`denial_reason_id` = `dr`.`id`))) left join `users` `u` on((`c`.`user_id` = `u`.`id`)))
			");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function alter_tables_coupon_coupon_type()
	{
		try {
			DB::statement("alter table `coupons` add `offer_code` varchar(255) null,add `promotion_title` varchar(255) null, add `start_date` date null");
			DB::statement("RENAME TABLE coupon_types TO coupon_types_old");
			DB::statement("CREATE TABLE coupon_types AS SELECT * FROM coupon_types_old");
			DB::statement("ALTER TABLE `coupon_types` ADD PRIMARY KEY(`id`)");
			DB::statement("ALTER TABLE `coupon_types` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
			echo "Done";
		} catch (Exception $e) {
			echo $e;
		}
	}

	public function alter_entries_mir_for_filter() {
		try {
			DB::statement("
			CREATE OR REPLACE VIEW `entries_mir_view` AS select `e`.`id` AS `id`,`e`.`dollar_value` AS `dollar_value`,
			`r`.`name` AS `retailer`,`c`.`name` AS `coupon`,`c`.`id` AS `coupon_id`,`c`.`coupon_type_id` 
			AS `coupon_type_id`,concat_ws(' ',`u`.`first_name`,`u`.`last_name`) AS `owner`,
			`s`.`name` AS `status`,`e`.`first_name` AS `first_name`,`e`.`last_name` AS `last_name`,`e`.`address` 
			AS `address`,`e`.`city` AS `city`,`e`.`state` AS `state`,`e`.`zip` AS `zip`,case when 
			`c`.`campaign_type` is null then 'Not Defined' else `c`.`campaign_type` end AS `campaign_type`,
			case when `c`.`campaign_logo` is null then 'N/A' else `c`.`campaign_logo` end 
			AS `campaign_logo`,`e`.`birth_date` AS `birth_date`,`e`.`invoiced_date` 
			AS `invoiced_date`,`dr`.`name` AS `denial_reason_id`,`e`.`created_at` AS `created_at` 
			from (((((`bevpromo`.`entries_mir` `e` left join `bevpromo`.`mir_retailers` `r` on(`e`.`mir_retailer_id` = `r`.`id`)) left join `bevpromo`.`coupons` `c` on(`e`.`coupon_id` = `c`.`id`)) left join `bevpromo`.`mir_statuses` `s` on(`e`.`mir_status_id` = `s`.`id`)) left join `bevpromo`.`mir_denial_reasons` `dr` on(`e`.`denial_reason_id` = `dr`.`id`)) left join `bevpromo`.`users` `u` on(`c`.`user_id` = `u`.`id`))
			");
		} catch (Exception $e) {
			echo $e;
		}
		echo "Done";
	}

	public function alter_coupon()
	{
		try {
			DB::statement("alter table `coupons` add `promotion_title` varchar(255) null");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function create_customer()
	{
		try {
			DB::statement("create table `customers` 
			(`id` bigint unsigned not null auto_increment primary key, `dob` date not null, `gender` 
			enum('male', 'female', 'other') not null, `rebate_method` enum('check', 'paypal') not null, 
			`first_name` varchar(255) not null, `last_name` varchar(255) not null, `company_name` varchar(255) not null, 
			`phone_num` varchar(255) not null, `email` varchar(255) not null, `street_address` varchar(255) not null, 
			`appartment_num` varchar(255) not null, `zip` varchar(255) not null, `city` varchar(255) not null, 
			`country` varchar(255) not null, `state` varchar(255) not null, `created_at` timestamp default 0 not null, 
			`updated_at` timestamp default 0 not null) default character set utf8 collate utf8_unicode_ci");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function update_customer() {
		try {
			DB::statement("alter table `customers` add `coupon_id` int not null, add `tracking_id` varchar(255) not null");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function create_customer_view() {
		try {
			DB::statement("CREATE VIEW customers_view AS select cu.id AS customer_id, cu.dob as dob, cu.gender as gender, cu.rebate_method as rebate_method, concat(cu.first_name, ' ', cu.last_name) AS customer_name,cu.company_name as company_name,cu.phone_num as phone_num,cu.email as email,cu.street_address as street_address,cu.appartment_num as appartment_num, cu.zip as zip, cu.city as city,cu.country as country, cu.state as state, cu.created_at as created_at, cu.updated_at as updated_at, cu.tracking_id as tracking_id, c.id AS id,c.id AS coupon_id,c.name AS name,c.expires
			AS expires,
			c.receive_by AS receive_by,c.coupon_type_id AS coupon_type_id,c.barcode AS barcode,(case when (c.active <> 0) then 'Yes' else 'No' end) AS active,(case when (c.campaign_type is null) then 'Not Defined' else c.campaign_type end) AS campaign_type,(case when (c.url_str is null) then 'N/D' else c.url_str end) AS campaign_url,(case when (c.campaign_logo is null) then 'N/A' else c.campaign_logo end) AS campaign_logo,
			concat(u.first_name,'  ',u.last_name) AS user,ct.name AS coupon_type,b.name AS brand from customers cu join coupons c on cu.coupon_id = c.id join brands b on c.brand_id = b.id join coupon_types ct on c.coupon_type_id = ct.id join users u on c.user_id = u.id");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function create_customer_ups_img()
	{
		try {
			DB::statement("create table `customer_upc_images` (`id` bigint unsigned not null auto_increment primary key, 
			`customer_id` int unsigned not null, `image` varchar(255) not null, `created_at` timestamp default 0 not null,
			`updated_at` timestamp default 0 not null) default character set utf8 collate utf8_unicode_ci");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function create_customer_rec_img()
	{
		try {
			DB::statement("create table `customer_receipt_images` (`id` bigint unsigned not null auto_increment primary key, 
			`customer_id` int unsigned not null, `image` varchar(255) not null, 
			`created_at` timestamp default 0 not null, `updated_at` timestamp default 0 not null) 
			default character set utf8 collate utf8_unicode_ci");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}

	public function alter_customer_for_paypal() {
		try {
			DB::statement("alter table `customers` add `paypal_email` varchar(255) not null after `email`");
			DB::statement("CREATE OR REPLACE VIEW customers_view AS select cu.id AS customer_id, cu.dob as dob, cu.gender as gender, cu.rebate_method as rebate_method, concat(cu.first_name, ' ', cu.last_name) AS customer_name,cu.company_name as company_name,cu.phone_num as phone_num,cu.email as email,cu.paypal_email as paypal_email,cu.street_address as street_address,cu.appartment_num as appartment_num, cu.zip as zip, cu.city as city,cu.country as country, cu.state as state, cu.created_at as created_at, cu.updated_at as updated_at, cu.tracking_id as tracking_id, c.id AS id,c.id AS coupon_id,c.name AS name,c.expires
			AS expires,
			c.receive_by AS receive_by,c.coupon_type_id AS coupon_type_id,c.barcode AS barcode,(case when (c.active <> 0) then 'Yes' else 'No' end) AS active,(case when (c.campaign_type is null) then 'Not Defined' else c.campaign_type end) AS campaign_type,(case when (c.url_str is null) then 'N/D' else c.url_str end) AS campaign_url,(case when (c.campaign_logo is null) then 'N/A' else c.campaign_logo end) AS campaign_logo,
			concat(u.first_name,'  ',u.last_name) AS user,ct.name AS coupon_type,b.name AS brand from customers cu join coupons c on cu.coupon_id = c.id join brands b on c.brand_id = b.id join coupon_types ct on c.coupon_type_id = ct.id join users u on c.user_id = u.id");
		} catch (Exception $th) {
			echo $th;
		}
		echo "Done";
	}
}
