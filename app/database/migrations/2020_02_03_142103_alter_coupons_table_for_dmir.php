<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCouponsTableForDmir extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('coupons', function (Blueprint $table) {
			$table->string('offer_code')->nullable();
			$table->date('start_date')->nullable();
			$table->string('promotion_title')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 
	 * @return void
	 */
	public function down()
	{
		Schema::table('coupons', function (Blueprint $table) {
			$table->dropColumn('offer_code');
			$table->dropColumn('start_date');
		});
	}

}
