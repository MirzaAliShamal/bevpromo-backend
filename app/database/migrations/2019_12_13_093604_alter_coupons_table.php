<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('coupons', function ($table) {
			$table->string('campaign_type')->nullable();
			$table->string('campaign_logo')->nullable(); 
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('coupons', function (Blueprint $table) {
			$table->dropColumn('campaign_type');
			$table->dropColumn('campaign_logo');
		});
	}

}
