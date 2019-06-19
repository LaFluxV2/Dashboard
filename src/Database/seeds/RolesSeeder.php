<?php

use ExtensionsValley\Dashboard\Models\Roles;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Roles::create([
            'name' => 'Super Admin',
            'role_type' => 'SU',
            'status' => '1',
            'created_by' => '1',
            'updated_by' => '1',
        ]);

        Roles::create([
            'name' => 'Admin',
            'role_type' => 'A',
            'status' => '1',
            'created_by' => '1',
            'updated_by' => '1',
        ]);

    }
}
