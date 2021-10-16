<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateIrcEntriesView extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("DROP VIEW entries_irc_view");

		DB::statement("CREATE VIEW entries_irc_view AS
            SELECT
                e.id,
                r.name AS retailer,
                r.state AS retailer_state,
                c.name AS program,
                c.id AS coupon_id,
                ch.name AS clearinghouse,
                (CASE WHEN e.is_invoiced <> 0 THEN 'Yes' ELSE 'No' END) AS is_invoiced,
                e.coupon_quantity,
                e.payable,
                e.shipping,
                u.id AS client_id,
                CONCAT(u.first_name, ' ', u.last_name) AS client_name,
                b.name AS brand,
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
                ON e.clearinghouse_id = ch.id
                JOIN users u
                ON c.user_id = u.id
                JOIN brands b
                ON c.brand_id = b.id");
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
