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
        $volunteerRole = Role::create(['name' => Constants::VOLUNTEER]);
        $superAdminRole = Role::create(['name' => Constants::SUPER_ADMIN]);
        $regionalCordinatorRole = Role::create(['name' => Constants::REGIONAL_COORDINATOR]);
        $systemUserCordinatorRole = Role::create(['name' => Constants::SYSTEM_USER]);
        $zoneCordinatorRole = Role::create(['name' => Constants::ZONE_COORDINATOR]);
        $deskRole = Role::create(['name' => Constants::DESK]);
        $generalRole = Role::create(['name' => Constants::GENERAL]);
        $adminRole = Role::create(['name' => Constants::ADMIN]);
    }
}
