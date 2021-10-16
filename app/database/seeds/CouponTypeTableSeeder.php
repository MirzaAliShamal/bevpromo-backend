<?php

class CouponTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('coupon_types')->truncate();

        CouponType::create(['id' => '1', 'name' => '']);
        CouponType::create(['id' => '2', 'name' => 'On-Pack Sticker']);
        CouponType::create(['id' => '3', 'name' => 'Tear Pad']);
        CouponType::create(['id' => '4', 'name' => 'Online Placement']);
        CouponType::create(['id' => '5', 'name' => 'Kiosk']);
        CouponType::create(['id' => '6', 'name' => 'Newspaper']);
        CouponType::create(['id' => '7', 'name' => 'Other']);
        CouponType::create(['id' => '13', 'name' => 'IRC']);
        CouponType::create(['id' => '14', 'name' => 'Digital Safeway']);
        CouponType::create(['id' => '15', 'name' => 'IN-AD']);
        CouponType::create(['id' => '16', 'name' => 'web']);
        CouponType::create(['id' => '17', 'name' => 'Mail-In Rebate']);

    }
}