<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveExtrasFromCouponTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 1;
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 2;
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 4;
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 5;
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 6;
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 13;
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 15;
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 16;
		DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 17;
		
		");
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