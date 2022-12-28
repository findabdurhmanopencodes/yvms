<?php

namespace Database\Seeders;

use App\Constants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
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
        $regionalCordinatorRole->syncPermissions([
            Permission::findOrCreate('dashboard.index'),
            Permission::findOrCreate('TrainingSession.index'),
            Permission::findOrCreate('Volunteer.index'),
            Permission::findOrCreate('Volunteer.show'),
            Permission::findOrCreate('Volunteer.verified.applicant'),
            Permission::findOrCreate('HierarchyReport.index'),
            Permission::findOrCreate('HierarchyReport.list'),
            Permission::findOrCreate('HierarchyReport.store'),
            Permission::findOrCreate('HierarchyReport.show'),
            Permission::findOrCreate('HierarchyReport.update'),
            Permission::findOrCreate('HierarchyReport.destroy'),
            Permission::findOrCreate('VolunteerDeployment.attendanceExport'),
            Permission::findOrCreate('VolunteerDeployment.attendanceImport'),
            Permission::findOrCreate('deployment.checkIn'),
            // Permission::findOrCreate('checker'),
        ]);
        $zoneCordinatorRole->syncPermissions([
            Permission::findOrCreate('dashboard.index'),
            Permission::findOrCreate('TrainingSession.index'),
            Permission::findOrCreate('Volunteer.index'),
            Permission::findOrCreate('Volunteer.show'),
            Permission::findOrCreate('Volunteer.verified.applicant'),
            Permission::findOrCreate('HierarchyReport.index'),
            Permission::findOrCreate('HierarchyReport.list'),
            Permission::findOrCreate('HierarchyReport.store'),
            Permission::findOrCreate('HierarchyReport.show'),
            Permission::findOrCreate('HierarchyReport.update'),
            Permission::findOrCreate('HierarchyReport.destroy'),
            Permission::findOrCreate('VolunteerDeployment.attendanceExport'),
            Permission::findOrCreate('VolunteerDeployment.attendanceImport'),
            Permission::findOrCreate('deployment.checkIn'),
            // Permission::findOrCreate('checker'),
        ]);
    }
}
