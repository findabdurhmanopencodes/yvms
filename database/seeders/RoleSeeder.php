<?php

namespace Database\Seeders;

use App\Constants;
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
        $volunteerRole = Role::findOrCreate(Constants::VOLUNTEER);
        $superAdminRole = Role::findOrCreate(Constants::SUPER_ADMIN);
        $regionalCordinatorRole = Role::findOrCreate(Constants::REGIONAL_COORDINATOR);
        $systemUserCordinatorRole = Role::findOrCreate(Constants::SYSTEM_USER);
        $zoneCordinatorRole = Role::findOrCreate(Constants::ZONE_COORDINATOR);
        $deskRole = Role::findOrCreate(Constants::DESK);
        $generalRole = Role::findOrCreate(Constants::GENERAL);
        $adminRole = Role::findOrCreate(Constants::ADMIN);
    }

}
