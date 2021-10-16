<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCouponsTableForCampaignType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("UPDATE coupons set campaign_type=1 WHERE coupon_type_id=17");
		DB::statement("UPDATE coupons set campaign_type=2 where coupon_type_id<>17 and campaign_type is Null");	
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