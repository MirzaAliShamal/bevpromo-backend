<?php

use Illuminate\Database\Migrations\Migration;

class CreateBrandView extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW brand_view AS
            SELECT
                b.id,
                b.name,
                (CASE WHEN b.irc_active <> 0 THEN 'Yes' ELSE 'No' END) As irc_active,
                (CASE WHEN b.mir_active <> 0 THEN 'Yes' ELSE 'No' END) As mir_active,
                s.name AS supplier,
                b.created_at,
                b.updated_at
            FROM
                brands b
                JOIN suppliers s
                ON b.supplier_id = s.id
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW brand_view");
    }
}