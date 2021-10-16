<?php

class MirDenialReasonTableSeeder extends Seeder {

    public function run()
    {
        DB::table('mir_denial_reasons')->truncate();

        MirDenialReason::create(['id' => '1', 'name' => 'Duplicate Receipt']);
        MirDenialReason::create(['id' => '2', 'name' => 'Duplicate Entry']);
        MirDenialReason::create(['id' => '3', 'name' => 'Household Limit Exceeded']);
        MirDenialReason::create(['id' => '4', 'name' => 'Original Receipt Not Provided']);
        MirDenialReason::create(['id' => '5', 'name' => 'Resubmitted']);
        MirDenialReason::create(['id' => '6', 'name' => 'No Receipt']);
        MirDenialReason::create(['id' => '7', 'name' => 'Purchase Requirement Not Met']);
        MirDenialReason::create(['id' => '8', 'name' => 'Other Terms Not Met']);
        MirDenialReason::create(['id' => '9', 'name' => 'No UPC provided']);
        MirDenialReason::create(['id' => '10', 'name' => 'Expired Offer']);
        MirDenialReason::create(['id' => '11', 'name' => '']);
        MirDenialReason::create(['id' => '12', 'name' => 'Fraud']);
        MirDenialReason::create(['id' => '13', 'name' => 'Not a Valid Receipt']);

    }
}