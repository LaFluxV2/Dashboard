<?php

use ExtensionsValley\Dashboard\Models\Users;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{

    public function run()
    {

        Users::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@laflux.com',
            'password' => bcrypt('123456'),
            'user_type' => "SU",
            'status' => '1'
        ]);

        Users::create([
            'name' => 'Admin',
            'email' => 'admin@laflux.com',
            'password' => bcrypt('123456'),
            'user_type' => "A",
            'status' => '1'
        ]);


    }
}
