<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCouponTableForColors extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE `coupons` ADD `line_hr_color` VARCHAR(255) NULL AFTER `footer_text`, ADD `nav_color` VARCHAR(255) NULL AFTER `line_hr_color`, ADD `field_span_color` VARCHAR(255) NULL AFTER `nav_color`");
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
