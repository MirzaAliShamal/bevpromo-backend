<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNoneEntryInCouponTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("INSERT INTO `coupon_types` (`id`, `name`, `created_at`, `updated_at`) VALUES ('0', 'None', CURRENT_DATE(), CURRENT_TIME());");
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
