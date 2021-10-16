<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWinEmailToSweepstakeProgramDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sweepstake_program_details', function(Blueprint $table)
		{
			DB::statement("ALTER TABLE sweepstake_program_details ADD win_email longtext NULL");

			
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