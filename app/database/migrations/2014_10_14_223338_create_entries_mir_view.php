<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntriesMirView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE VIEW entries_mir_view AS
            SELECT
                e.id,
                r.name AS retailer,
                c.name AS coupon,
                c.id AS coupon_id,
                s.name AS status,
                e.first_name,
                e.last_name,
                e.address,
                e.city,
                e.state,
                e.zip,
                e.created_at,
                e.program_type
            FROM
                entries_mir e
                LEFT JOIN mir_retailers r
                ON e.mir_retailer_id = r.id
                LEFT JOIN coupons c
                ON e.coupon_id = c.id
                LEFT JOIN mir_statuses s
                ON e.mir_status_id = s.id");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('entries_mir_view');
	}

}
