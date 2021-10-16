<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgegateImageColumnInCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('coupons', function (Blueprint $table) {
            $table->string('agegate_image')->nullable()->after('campaign_logo');
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
			$table->dropColumn('agegate_image');
		});
	}

}
