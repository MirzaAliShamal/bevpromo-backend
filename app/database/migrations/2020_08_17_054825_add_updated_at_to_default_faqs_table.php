<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdatedAtToDefaultFaqsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('default_faqs', function(Blueprint $table)
		{
			DB::statement("ALTER TABLE default_faqs ADD updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW()");			
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