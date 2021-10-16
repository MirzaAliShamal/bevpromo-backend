<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntriesMirTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entries_mir', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('coupon_id')->unsigned()->nullable();
			$table->decimal('dollar_value', 9, 2)->nullable();
			$table->string('first_name', 255)->nullable();
			$table->string('last_name', 255)->nullable();
			$table->string('address', 255)->nullable();
			$table->string('city', 255)->nullable();
			$table->string('state', 255)->nullable();
			$table->string('zip', 255)->nullable();
			$table->string('email', 255)->nullable();
			$table->date('birth_date')->nullable();
			$table->integer('mir_retailer_id')->unsigned()->nullable();
			$table->date('invoiced_date')->nullable();
			$table->date('paid_out_date')->nullable();
			$table->integer('mir_status_id')->unsigned()->nullable();
			$table->integer('denial_reason_id')->unsigned()->nullable();
			$table->integer('invoice_id')->unsigned()->nullable();
			$table->softDeletes();
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
		Schema::drop('entries_mir');
	}

}
