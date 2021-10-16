<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSendToTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('send_to', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->string('name', 255)->nullable();
            $table->string('department', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->integer('clearinghouse_id')->unsigned()->nullable();
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
		Schema::drop('send_to');
	}

}
