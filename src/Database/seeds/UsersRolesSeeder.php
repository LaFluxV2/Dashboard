<?php

use ExtensionsValley\Dashboard\Models\Userroles;
use Illuminate\Database\Seeder;

class UsersRolesSeeder extends Seeder
{

    public function run()
    {

        Userroles::create([
            'user_id' => 1, // Super Admin User
            'role_id' => 1, // Super Admin Role
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1
        ]);

        Userroles::create([
            'user_id' => 2, // Admin User
            'role_id' => 2, // Admin Role
            'status' => 1,
            'created_by' => 1,
            'updated_by' => 1
        ]);


    }
}
