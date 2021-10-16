<?php

use Illuminate\Database\Migrations\Migration;

class CreateCouponsIrcView extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW coupons_irc_view AS
            SELECT
                c.id,
                c.name,
                c.expires,
                c.receive_by,
                c.barcode,
               (CASE WHEN c.active <> 0 THEN 'Yes' ELSE 'No' END) As active,
                CONCAT(u.first_name, ' ', u.last_name)  AS user,
                ct.name AS coupon_type,
                b.name AS brand,
                c.created_at,
                c.updated_at
            FROM
                coupons c
                JOIN brands b
                ON c.brand_id = b.id
                JOIN coupon_types ct
                ON c.coupon_type_id = ct.id
                JOIN users u
                ON c.user_id = u.id
            WHERE c.coupon_type_id != 17
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW coupons_irc_view");
    }
}