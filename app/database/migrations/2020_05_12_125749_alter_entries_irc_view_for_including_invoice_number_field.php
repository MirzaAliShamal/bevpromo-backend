<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEntriesIrcViewForIncludingInvoiceNumberField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE OR REPLACE VIEW `entries_irc_view` AS 
		select `e`.`id` AS `id`,`r`.`name` AS `retailer`,`r`.`state` AS `retailer_state`,`c`.`name` 
		AS `program`,`c`.`id` AS `coupon_id`,`ch`.`name` AS `clearinghouse`,concat_ws(' ',`u`.`first_name`,`u`.`last_name`) 
		AS `owner`,case when `e`.`is_invoiced` <> 0 then 'Yes' else 'No' end AS `is_invoiced`,`e`.`client_invoice` 
		AS `client_invoice`,`e`.`coupon_quantity` AS `coupon_quantity`,`e`.`payable` AS `payable`,case when `c`.`campaign_type` 
		is null then 'Not Defined' else `c`.`campaign_type` end AS `campaign_type`,case when `c`.`campaign_logo` 
		is null then 'N/A' else `c`.`campaign_logo` end AS `campaign_logo`,`c`.`expires` AS `coupon_expiry`,
		case when `c`.`active` <> 0 then 'Yes' else 'No' end AS `active`,`c`.`barcode` AS `barcode`,`e`.`shipping` 
		AS `shipping`,`u`.`id` AS `client_id`,concat(`u`.`first_name`,' ',`u`.`last_name`) AS `client_name`,`b`.`name` 
		AS `brand`,`e`.`created_at` AS `created_at`,`e`.`updated_at` AS `updated_at`,`e`.`deleted_at` AS `deleted_at` 
		from (((((`bevpromo`.`entries_irc` `e` left join `bevpromo`.`retailers` `r` on(`e`.`retailer_id` = `r`.`id`)) 
		left join `bevpromo`.`coupons` `c` on(`e`.`coupon_id` = `c`.`id`)) left join `bevpromo`.`clearinghouses` `ch` 
		on(`e`.`clearinghouse_id` = `ch`.`id`)) join `bevpromo`.`users` `u` on(`c`.`user_id` = `u`.`id`)) join `bevpromo`.`brands` `b` 
		on(`c`.`brand_id` = `b`.`id`))");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
