<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesForEmailChanges extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE `customers` CHANGE `appartment_num` `appartment_num` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");
		DB::statement("ALTER TABLE `customers` CHANGE `gender` `gender` ENUM('male','female','other') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;");
		DB::statement("ALTER TABLE `coupons` ADD `welcome_message` LONGTEXT NULL AFTER `sponsor_information`;");
		DB::statement("ALTER TABLE `coupons` ADD `brand_privacy` LONGTEXT NULL AFTER `welcome_message`;");
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
