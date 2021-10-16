<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntriesIrcTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entries_irc', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('retailer_id')->unsigned()->nullable();
			$table->integer('coupon_id')->unsigned()->nullable();
			$table->integer('coupon_quantity')->unsigned()->nullable();
			$table->decimal('payable', 9, 2)->nullable();
			$table->decimal('shipping', 9, 2)->nullable();
			$table->string('quickbooks')->nullable();
			$table->string('client_invoice')->nullable();
			$table->integer('clearinghouse_id')->unsigned()->nullable();
			$table->integer('invoice_id')->unsigned()->nullable();
			$table->boolean('is_invoiced');
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
		Schema::drop('entries_irc');
	}

}
