<?php

class RoleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->truncate();

        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'reporting'
        ]);
    }

}