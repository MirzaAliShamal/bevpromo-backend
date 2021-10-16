<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('imports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('status_id')->unsigned()->nullable();
			$table->string('status_name')->nullable();
			$table->dateTime('timestamp')->nullable();
			$table->string('transaction_id')->nullable();
			$table->string('payee')->nullable();
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
		Schema::drop('import');
	}

}
