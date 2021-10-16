<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEntriesMirForPaidDefault extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('entries_mir', function (Blueprint $table) {
			DB::statement("ALTER TABLE `entries_mir` CHANGE `paid_status` `paid_status` ENUM('pending','paid','denied') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'pending'");
			DB::statement("UPDATE entries_mir SET entries_mir.paid_status = 'pending' where paid_status = null");
			DB::statement("ALTER TABLE `customers` CHANGE `paypal_email` `paypal_email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL");
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
