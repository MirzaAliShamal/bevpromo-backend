<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCouponTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("RENAME TABLE coupon_types TO coupon_types_old");
		DB::statement("CREATE TABLE coupon_types AS SELECT * FROM coupon_types_old");
		DB::statement("ALTER TABLE `coupon_types` ADD PRIMARY KEY(`id`)");
		DB::statement("ALTER TABLE `coupon_types` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("DROP TABLE coupon_types");
		DB::statement("RENAME TABLE coupon_types_old TO coupon_types");
	}

}
