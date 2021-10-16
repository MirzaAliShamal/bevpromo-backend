<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCouponsIrcView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("DROP VIEW IF EXISTS coupons_irc_view");

		DB::statement("CREATE VIEW coupons_irc_view AS
            

			SELECT
				`c`.`id` AS `id`,
				`c`.`name` AS `name`,
				`c`.`expires` AS `expires`,
				`c`.`receive_by` AS `receive_by`,
				`c`.`barcode` AS `barcode`,
				CASE WHEN `c`.`active` <> 0 THEN 'Yes' ELSE 'No'
			END AS `active`,
			CONCAT(`u`.`first_name`, ' ', `u`.`last_name`) AS `user`,
			`ct`.`name` AS `coupon_type`,
			`b`.`name` AS `brand`,
			`c`.`created_at` AS `created_at`,
			`c`.`updated_at` AS `updated_at`
			FROM
				(
					(
						(
							`bevpromo_com_virtual`.`coupons` `c`
						JOIN `bevpromo_com_virtual`.`brands` `b`
						ON
							(`c`.`brand_id` = `b`.`id`)
						)
					JOIN `bevpromo_com_virtual`.`coupon_types` `ct`
					ON
						(`c`.`coupon_type_id` = `ct`.`id`)
					)
				JOIN `bevpromo_com_virtual`.`users` `u`
				ON
					(`c`.`user_id` = `u`.`id`)
				)
			WHERE
				`c`.`campaign_type` = 2
		");
	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('coupons_irc_view');
	}

}