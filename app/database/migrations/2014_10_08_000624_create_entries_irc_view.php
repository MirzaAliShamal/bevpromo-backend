<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntriesIrcView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE VIEW entries_irc_view AS
            SELECT
                e.id,
                r.name AS retailer,
                c.name AS program,
                c.id AS coupon_id,
                ch.name AS clearinghouse,
                (CASE WHEN e.is_invoiced <> 0 THEN 'Yes' ELSE 'No' END) AS is_invoiced,
                e.coupon_quantity,
                e.payable,
                e.shipping,
                e.created_at,
                e.updated_at,
                e.deleted_at
            FROM
                entries_irc e
                LEFT JOIN retailers r
                ON e.retailer_id = r.id
                LEFT JOIN coupons c
                ON e.coupon_id = c.id
                LEFT JOIN clearinghouses ch
                ON e.clearinghouse_id = ch.id");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('entries_irc_view');
	}

}
