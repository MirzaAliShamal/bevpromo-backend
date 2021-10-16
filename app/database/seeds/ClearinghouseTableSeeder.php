<?php

class ClearinghouseTableSeeder extends Seeder {

    public function run()
    {
        DB::table('clearinghouses')->truncate();

        Clearinghouse::create(['id' => '1', 'name' => '']);
        Clearinghouse::create(['id' => '3', 'name' => 'BEVcoupons']);
        Clearinghouse::create(['id' => '5', 'name' => 'Vermouth']);
        Clearinghouse::create(['id' => '2', 'name' => 'CMS']);
        Clearinghouse::create(['id' => '6', 'name' => 'Bacardi']);
        Clearinghouse::create(['id' => '7', 'name' => 'Hennessy']);
        Clearinghouse::create(['id' => '8', 'name' => 'Pyramid']);
        Clearinghouse::create(['id' => '9', 'name' => 'Cazadoras']);
        Clearinghouse::create(['id' => '10', 'name' => 'Brown-Forman']);
        Clearinghouse::create(['id' => '11', 'name' => 'CSM']);
        Clearinghouse::create(['id' => '12', 'name' => 'CWUS']);
        Clearinghouse::create(['id' => '13', 'name' => 'DeBeukelaer Baking Co.']);
        Clearinghouse::create(['id' => '14', 'name' => 'Dr. Pepper/Seven Up, Inc.']);
        Clearinghouse::create(['id' => '15', 'name' => 'ECO/MDS Foods Inc.']);
        Clearinghouse::create(['id' => '16', 'name' => 'J. Lohr Estates Wine']);
        Clearinghouse::create(['id' => '17', 'name' => 'Kettle Brand']);
        Clearinghouse::create(['id' => '18', 'name' => 'Kobrand Coupon redemption']);
        Clearinghouse::create(['id' => '19', 'name' => 'Mandlik & Rhodes']);
        Clearinghouse::create(['id' => '20', 'name' => 'MPS']);
        Clearinghouse::create(['id' => '21', 'name' => 'NCH']);
        Clearinghouse::create(['id' => '22', 'name' => 'Sobieski']);
        Clearinghouse::create(['id' => '23', 'name' => 'BIV']);
        Clearinghouse::create(['id' => '24', 'name' => 'Unilever']);
        Clearinghouse::create(['id' => '25', 'name' => 'Universal']);
        Clearinghouse::create(['id' => '26', 'name' => 'OFICRS']);
        Clearinghouse::create(['id' => '27', 'name' => 'Supervalu']);
        Clearinghouse::create(['id' => '28', 'name' => 'Al\'s Mini Mart']);
        Clearinghouse::create(['id' => '29', 'name' => 'Mandlik & Rhodes C/O TK Manufacturing Services Inc.']);
        Clearinghouse::create(['id' => '30', 'name' => 'S.E.A. Enterprises']);
        Clearinghouse::create(['id' => '31', 'name' => 'B&M Processing Co Inc']);
        Clearinghouse::create(['id' => '32', 'name' => 'G-ID Retail SVC']);
    }

}