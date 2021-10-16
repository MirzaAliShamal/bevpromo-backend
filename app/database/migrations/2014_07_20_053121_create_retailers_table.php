<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRetailersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('retailers', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->string('name', 255)->nullable();
			$table->string('address', 255)->nullable();
			$table->string('city', 255)->nullable();
			$table->string('state')->nullable();
			$table->string('zip', 255)->nullable();
            $table->boolean('is_active')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('retailers');
	}

}
