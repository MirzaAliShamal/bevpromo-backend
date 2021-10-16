<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFormTitleAndFormTextColorInSweepstakeProgramDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE `sweepstake_program_details` ADD `form_title_color` VARCHAR(191) NULL DEFAULT NULL AFTER `daily_limit`, ADD `form_text_color` VARCHAR(191) NULL DEFAULT NULL AFTER `form_title_color`;");
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
