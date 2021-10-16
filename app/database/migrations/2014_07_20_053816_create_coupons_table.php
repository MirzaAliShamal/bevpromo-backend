<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupons', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->string('name', 255)->nullable();
            $table->decimal('value', 9, 2);
            $table->string('description', 255)->nullable();
            $table->date('expires')->nullable();
            $table->date('receive_by')->nullable();
            $table->string('barcode', 255)->nullable();
            $table->string('states', 255)->nullable();
            $table->integer('circulation')->unsigned()->nullable();
            $table->boolean('active')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('brand_id')->unsigned()->nullable();
            $table->integer('send_to_id')->unsigned()->nullable();
            $table->integer('clearinghouse_id')->unsigned()->nullable();
            $table->integer('coupon_type_id')->unsigned()->nullable();
            $table->integer('old_mir_id')->unsigned()->nullable();
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
		Schema::drop('coupons');
	}

}
