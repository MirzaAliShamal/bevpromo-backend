<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdatedAtToDefaultFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('default_fields', function(Blueprint $table)
		{
			DB::statement("ALTER TABLE default_fields ADD updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW()");			
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
