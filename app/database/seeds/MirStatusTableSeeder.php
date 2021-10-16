<?php

class MirStatusTableSeeder extends Seeder {

    public function run()
    {
        DB::table('mir_statuses')->truncate();

        MirStatus::create(['id' => '1', 'name' => 'Received']);
        MirStatus::create(['id' => '2', 'name' => 'Denied']);
        MirStatus::create(['id' => '3', 'name' => 'Paid']);
        MirStatus::create(['id' => '4', 'name' => 'Duplicate']);
        MirStatus::create(['id' => '5', 'name' => 'Invoiced']);
        MirStatus::create(['id' => '6', 'name' => 'Resubmitted']);
        MirStatus::create(['id' => '7', 'name' => 'Redeemed']);

    }
}