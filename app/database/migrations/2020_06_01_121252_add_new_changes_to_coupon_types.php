<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNewChangesToCouponTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("DELETE FROM `coupon_types` WHERE `coupon_types`.`id` = 25;");
		DB::statement("UPDATE `coupon_types` SET `name` = 'None' WHERE `coupon_types`.`id` = 1;");	
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}
