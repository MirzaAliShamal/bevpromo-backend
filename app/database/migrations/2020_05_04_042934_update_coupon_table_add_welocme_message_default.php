<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCouponTableAddWelocmeMessageDefault extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		DB::statement("UPDATE `coupons` SET `welcome_message` = '<h1>Welcome</h1> <h2>Welcome to the Beverage Promotions Rebate</h2> <p>You are just a few clicks away from submitting your rebate claim.</p> <p>TTo complete your online submission, you’ll need digital versions of your product receipt(s) and UPC(s). You will be able to submit either scans or photos of these two items.</p>' WHERE `coupons`.`campaign_type` = 3;");
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