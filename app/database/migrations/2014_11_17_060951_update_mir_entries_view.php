<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMirEntriesView extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS entries_mir_view");

        DB::statement("CREATE VIEW entries_mir_view AS
            SELECT
                e.id,
                e.dollar_value,
                r.name AS retailer,
                c.name AS coupon,
                c.id AS coupon_id,
                CONCAT_WS(' ', u.first_name, u.last_name) AS owner,
                s.name AS status,
                e.first_name,
                e.last_name,
                e.address,
                e.city,
                e.state,
                e.zip,
                e.birth_date,
                e.invoiced_date,
                dr.name AS denial_reason_id,
                e.created_at
            FROM
                entries_mir e
                LEFT JOIN mir_retailers r
                ON e.mir_retailer_id = r.id
                LEFT JOIN coupons c
                ON e.coupon_id = c.id
                LEFT JOIN mir_statuses s
                ON e.mir_status_id = s.id
                LEFT JOIN mir_denial_reasons dr
                ON e.denial_reason_id = dr.id
                LEFT JOIN users u
                ON c.user_id = u.id
                ");
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
