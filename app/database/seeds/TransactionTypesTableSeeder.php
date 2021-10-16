<?php

class TransactionTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('transaction_types')->truncate();

        TransactionTypes::create([
            'name' => 'Fee'
        ]);

        TransactionTypes::create([
            'name' => 'Credit'
        ]);
    }

}