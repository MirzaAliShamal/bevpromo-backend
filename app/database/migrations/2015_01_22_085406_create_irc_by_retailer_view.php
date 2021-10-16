<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIrcByRetailerView extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //DB::statement("DROP VIEW irc_by_retailer_view");

        DB::statement("CREATE VIEW irc_by_retailer_view AS
            SELECT
                r.name AS retailer,
                u.id AS user_id,
                DATE_FORMAT(e.created_at,'%Y-%m') AS month,
                DATE_FORMAT(e.created_at,'%M, %Y') AS month,
                SUM(e.coupon_quantity) as total
            FROM
                entries_irc e
                LEFT JOIN retailers r
                ON e.retailer_id = r.id
                LEFT JOIN coupons c
                ON e.coupon_id = c.id
                JOIN users u
                ON u.id = c.user_id
                GROUP BY month,
                retailer");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('irc_by_retailer_view');
    }

}
