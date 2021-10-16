<?php

class InvoiceTableSeeder extends Seeder {

    public function run()
    {
        DB::table('invoices')->truncate();

        Invoice::create([ 'id' => '1', 'user_id' => '2', 'name' => 'Test', 'invoice_status_id' => '1']);

    }

}