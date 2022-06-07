<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $volunteerRole = Role::create(['name' => 'volunteer']);
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $regionalCordinatorRole = Role::create(['name' => 'regional-coordinator']);
        $systemUserCordinatorRole = Role::create(['name' => 'system-user']);
        $zoneCordinatorRole = Role::create(['name' => 'zone-coordinator']);
    }
}
