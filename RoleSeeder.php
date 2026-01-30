<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Full access to all features'],
            ['name' => 'Manager', 'description' => 'Manage inventory,purchases, and reports'],
            ['name' => 'Staff', 'description' => 'Handle sales and view products'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
