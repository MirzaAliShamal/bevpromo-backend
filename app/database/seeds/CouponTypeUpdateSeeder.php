<?php 

class CouponTypeUpdateSeeder extends Seeder {
    public function run() {
        CouponType::create(['name' => 'Circular']);
        CouponType::create(['name' => 'Digital']);
        CouponType::create(['name' => 'Digital Print']);
        CouponType::create(['name' => 'Die Cut Necker']);
        CouponType::create(['name' => 'Elastitag']);
        CouponType::create(['name' => 'Elastic Necker']);
        CouponType::create(['name' => 'On-Pack']);

        
    }
}