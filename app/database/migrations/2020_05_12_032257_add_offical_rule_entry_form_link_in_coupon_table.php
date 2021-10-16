<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOfficalRuleEntryFormLinkInCouponTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE `sweepstake_program_details` ADD `official_rule_entry_link` VARCHAR(191) NULL DEFAULT NULL AFTER `form_align`;");

		DB::statement("ALTER TABLE `sweepstake_program_details` ADD `official_rule_entry_link_color` VARCHAR(191) NULL DEFAULT NULL AFTER `official_rule_entry_link`;");
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
