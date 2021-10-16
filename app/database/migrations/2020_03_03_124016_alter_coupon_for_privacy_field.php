<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCouponForPrivacyField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE `coupons` ADD `privacy_policy` LONGTEXT NULL AFTER `terms_conditions`");
		DB::statement("ALTER TABLE `coupons` ADD `copyright_text` LONGTEXT NULL AFTER `privacy_policy`");
		DB::statement("ALTER TABLE `coupons` ADD `footer_text` LONGTEXT NULL AFTER `copyright_text`");
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
