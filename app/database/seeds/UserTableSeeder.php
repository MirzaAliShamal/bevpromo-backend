<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->truncate();

        User::create([
            'email' => 'theotherbenjohnson@gmail.com',
            'password' => Hash::make('drittens'),
            'active' => 1,
            'first_name' => 'Ben',
            'last_name' => 'Johnson',
            'role_id' => 1,
            'phone' => '555-555-5555',
            'address' => '123 Fake St',
            'city' => 'Tempe',
            'state' => 'AZ',
            'zip' => '85282'
        ]);

        User::create([
            'email' => 'matt@bevcoupons.com',
            'password' => Hash::make('password01'),
            'active' => 1,
            'first_name' => 'Matt',
            'last_name' => 'deNicola',
            'role_id' => 1,
            'phone' => '555-555-5555',
            'address' => '123 Fake St',
            'city' => 'Tempe',
            'state' => 'AZ',
            'zip' => '85282'
        ]);

        User::create([
            'email' => 'carey@bevcoupons.com',
            'password' => Hash::make('password01'),
            'active' => 1,
            'first_name' => 'Carey',
            'last_name' => 'Uhl',
            'role_id' => 1,
            'phone' => '555-555-5555',
            'address' => '123 Fake St',
            'city' => 'Tempe',
            'state' => 'AZ',
            'zip' => '85282'
        ]);

        User::create([
            'email' => 'processing@bevcoupons.com',
            'password' => Hash::make('password01'),
            'active' => 1,
            'first_name' => 'Angie',
            'last_name' => '',
            'role_id' => 1,
            'phone' => '555-555-5555',
            'address' => '123 Fake St',
            'city' => 'Tempe',
            'state' => 'AZ',
            'zip' => '85282'
        ]);

        User::create([ 'id' => '56', 'email' => 'client56@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Wine Group/ Ashleigh']);
        User::create([ 'id' => '55', 'email' => 'client55@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Krave/Stephanie']);
        User::create([ 'id' => '54', 'email' => 'client54@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Bedford Int./David']);
        User::create([ 'id' => '53', 'email' => 'client53@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Cape Classics/Evan Whitacre']);
        User::create([ 'id' => '52', 'email' => 'client52@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Distillery209/D\'Shawn']);
        User::create([ 'id' => '51', 'email' => 'client51@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Stoli/Ervi Lee']);
        User::create([ 'id' => '50', 'email' => 'client50@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'SWS-CO/Brooke Javorek']);
        User::create([ 'id' => '49', 'email' => 'client49@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Katie Green- Invoice SWS (Cindy Leonard)']);
        User::create([ 'id' => '48', 'email' => 'client48@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Moosehead-Corp']);
        User::create([ 'id' => '47', 'email' => 'client47@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'SWS/Chris Costsa']);
        User::create([ 'id' => '46', 'email' => 'client46@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Stoli/Ethen Perkins']);
        User::create([ 'id' => '45', 'email' => 'client45@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Luxco/John Ware']);
        User::create([ 'id' => '44', 'email' => 'client44@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'SWS-CO/Marcus']);
        User::create([ 'id' => '43', 'email' => 'client43@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'C-Com/Andrew']);
        User::create([ 'id' => '42', 'email' => 'client42@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'SWS/Mike Reina']);
        User::create([ 'id' => '41', 'email' => 'client41@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Courtney Doss']);
        User::create([ 'id' => '40', 'email' => 'client40@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Titos/Shayne Brown']);
        User::create([ 'id' => '39', 'email' => 'client39@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Titos/Brendan Byass']);
        User::create([ 'id' => '38', 'email' => 'client38@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Titos/Jeff Hodson']);
        User::create([ 'id' => '37', 'email' => 'client37@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'SkinnyMixes/Reina Montero']);
        User::create([ 'id' => '36', 'email' => 'client36@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Luxco/Rich Valentine']);
        User::create([ 'id' => '35', 'email' => 'client35@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Andy Rose']);
        User::create([ 'id' => '34', 'email' => 'client34@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Moosehead/Don B']);
        User::create([ 'id' => '33', 'email' => 'client33@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Pinx/Keith Barone']);
        User::create([ 'id' => '32', 'email' => 'client32@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'WJ Deutsch/Jessica Wilder']);
        User::create([ 'id' => '31', 'email' => 'client31@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Duckhorn/Carol Reber']);
        User::create([ 'id' => '30', 'email' => 'client30@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'JM Shorrock/Craig Miller']);
        User::create([ 'id' => '29', 'email' => 'client29@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Proximo/John Wagner']);
        User::create([ 'id' => '28', 'email' => 'client28@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'PRUSA Prefund JR ALLEN']);
        User::create([ 'id' => '27', 'email' => 'client27@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Krave/Chelsea']);
        User::create([ 'id' => '26', 'email' => 'client26@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Titos/Marshall Waller']);
        User::create([ 'id' => '25', 'email' => 'client25@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Serralles/D\'Shawn']);
        User::create([ 'id' => '24', 'email' => 'client24@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Derek Myers']);
        User::create([ 'id' => '23', 'email' => 'client23@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Proximo/Miriam']);
        User::create([ 'id' => '22', 'email' => 'client22@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Moosehead/Phil S.']);
        User::create([ 'id' => '21', 'email' => 'client21@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'WJ/Darren Burke']);
        User::create([ 'id' => '20', 'email' => 'client20@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Katie Green']);
        User::create([ 'id' => '19', 'email' => 'client19@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'SWS/Brian Lathrop']);
        User::create([ 'id' => '18', 'email' => 'client18@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Titos/John Griffin']);
        User::create([ 'id' => '17', 'email' => 'client17@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Greg Ellison']);
        User::create([ 'id' => '16', 'email' => 'client16@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Carl Russo']);
        User::create([ 'id' => '15', 'email' => 'client15@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'New Age/Tiffany']);
        User::create([ 'id' => '14', 'email' => 'client14@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'PL360/O\'Neil']);
        User::create([ 'id' => '13', 'email' => 'client13@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'PRUSA/Kyla']);
        User::create([ 'id' => '12', 'email' => 'client12@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Moosehead/Dale']);
        User::create([ 'id' => '11', 'email' => 'client11@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Moosehead/Phil A']);
        User::create([ 'id' => '10', 'email' => 'client10@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'SWS/Tammy Turner']);
        User::create([ 'id' => '9', 'email' => 'client9@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Youngs/Mike Stein']);
        User::create([ 'id' => '8', 'email' => 'client8@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Alliance/Lisa Faccio']);
        User::create([ 'id' => '7', 'email' => 'client7@bevcoupons.com', 'password' => Hash::make('@cts123'), 'active' => 1, 'role_id' => '2', 'first_name' => 'Agave/Scott']);
    }

}