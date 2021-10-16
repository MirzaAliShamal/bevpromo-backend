<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->date('dob');
			$table->enum('gender',['male','female','other']);
			$table->enum('rebate_method',['check','paypal']);
			$table->string('first_name');
			$table->string('last_name');
			$table->string('company_name');
			$table->string('phone_num');
			$table->string('email');
			$table->string('street_address');
			$table->string('appartment_num');
			$table->string('zip');
			$table->string('city');
			$table->string('country');
			$table->string('state');
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
		Schema::dropIfExists('customers');
	}

}
