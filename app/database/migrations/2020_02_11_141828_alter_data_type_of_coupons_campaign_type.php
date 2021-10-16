<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDataTypeOfCouponsCampaignType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('coupons', function (Blueprint $table) {
			DB::statement("UPDATE coupons SET coupons.campaign_type = NULL");
			DB::statement("ALTER TABLE `coupons` CHANGE `campaign_type` `campaign_type` INT(10) NULL DEFAULT NULL");
		});
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
