<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    const CENTER_COORIDNATOR = 'centerCooridnator';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Permission::create(['name'=>'dashboard.index']);

        Permission::create(['name'=>'Disablity.index']);
        Permission::create(['name'=>'Disablity.store']);
        Permission::create(['name'=>'Disablity.show']);
        Permission::create(['name'=>'Disablity.update']);
        Permission::create(['name'=>'Disablity.destroy']);

        Permission::create(['name'=>'EducationalLevel.index']);
        Permission::create(['name'=>'EducationalLevel.store']);
        Permission::create(['name'=>'EducationalLevel.show']);
        Permission::create(['name'=>'EducationalLevel.update']);
        Permission::create(['name'=>'EducationalLevel.destroy']);

        Permission::create(['name'=>'Feadback.index']);
        Permission::create(['name'=>'Feadback.store']);
        Permission::create(['name'=>'Feadback.show']);
        Permission::create(['name'=>'Feadback.update']);
        Permission::create(['name'=>'Feadback.destroy']);

        Permission::create(['name'=>'FeildOfStudy.index']);
        Permission::create(['name'=>'FeildOfStudy.store']);
        Permission::create(['name'=>'FeildOfStudy.show']);
        Permission::create(['name'=>'FeildOfStudy.update']);
        Permission::create(['name'=>'FeildOfStudy.destroy']);

        Permission::create(['name'=>'File.file.Upload']);

        Permission::create(['name'=>'Permission.index']);
        Permission::create(['name'=>'Permission.store']);
        Permission::create(['name'=>'Permission.show']);
        Permission::create(['name'=>'Permission.update']);
        Permission::create(['name'=>'Permission.destroy']);

        Permission::create(['name'=>'Qouta.index']);
        Permission::create(['name'=>'Qouta.store']);
        Permission::create(['name'=>'Qouta.show']);
        Permission::create(['name'=>'Qouta.update']);
        Permission::create(['name'=>'Qouta.destroy']);


        Permission::create(['name'=>'Region.index']);
        Permission::create(['name'=>'Region.store']);
        Permission::create(['name'=>'Region.show']);
        Permission::create(['name'=>'Region.update']);
        Permission::create(['name'=>'Region.destroy']);
        Permission::create(['name'=>'Region.place']);
        Permission::create(['name'=>'Region.validate.form']);

        Permission::create(['name'=>'Role.index']);
        Permission::create(['name'=>'Role.store']);
        Permission::create(['name'=>'Role.show']);
        Permission::create(['name'=>'Role.update']);
        Permission::create(['name'=>'Role.destroy']);
        Permission::create(['name'=>'Role.permissions']);
        Permission::create(['name'=>'Role.give.permission']);
        Permission::create(['name'=>'Role.revoke.permission']);
        Permission::create(['name'=>'Role.give.all.Permission']);
        Permission::create(['name'=>'Role.remove.all.Permission']);

        Permission::create(['name'=>'TrainingCenterCapacity.index']);
        Permission::create(['name'=>'TrainingCenterCapacity.store']);
        Permission::create(['name'=>'TrainingCenterCapacitq.show']);
        Permission::create(['name'=>'TrainingCenterCapacity.update']);
        Permission::create(['name'=>'TrainingCenterCapacity.destroy']);
        Permission::create(['name'=>'TrainingCenterCapacity.capacity.Change']);


        Permission::create(['name'=>'TrainingMaster.index']);
        Permission::create(['name'=>'TrainingMaster.store']);
        Permission::create(['name'=>'TrainingMaster.show']);
        Permission::create(['name'=>'TrainingMaster.update']);
        Permission::create(['name'=>'TrainingMaster.destroy']);


        Permission::create(['name'=>'Training.index']);
        Permission::create(['name'=>'Training.store']);
        Permission::create(['name'=>'Training.show']);
        Permission::create(['name'=>'Training.update']);
        Permission::create(['name'=>'Training.destroy']);

        Permission::create(['name'=>'TrainingPlacement.index']);
        Permission::create(['name'=>'TrainingPlacement.store']);
        Permission::create(['name'=>'TrainingPlacement.show']);
        Permission::create(['name'=>'TrainingPlacement.update']);
        Permission::create(['name'=>'TrainingPlacement.destroy']);

        Permission::create(['name'=>'TrainingSession.index']);
        Permission::create(['name'=>'TrainingSession.store']);
        Permission::create(['name'=>'TrainingSession.show']);
        Permission::create(['name'=>'TrainingSession.destroy']);
        Permission::create(['name'=>'TrainingSession.update']);
        Permission::create(['name'=>'TrainingSession.show.quota']);
        Permission::create(['name'=>'TrainingSession.screen']);

        Permission::create(['name'=>'TraininingCenter.index']);
        Permission::create(['name'=>'TraininingCenter.store']);
        Permission::create(['name'=>'TraininingCenter.show']);
        Permission::create(['name'=>'TraininingCenter.update']);
        Permission::create(['name'=>'TraininingCenter.destroy']);
        Permission::create(['name'=>'TraininingCenter.placement']);

        Permission::create(['name'=>'UserRegion.index']);
        Permission::create(['name'=>'UserRegion.store']);
        Permission::create(['name'=>'UserRegion.show']);
        Permission::create(['name'=>'UserRegion.update']);
        Permission::create(['name'=>'UserRegion.destroy']);


        Permission::create(['name'=>'Volunteer.index']);
        Permission::create(['name'=>'Volunteer.store']);
        Permission::create(['name'=>'Volunteer.show']);
        Permission::create(['name'=>'Volunteer.update']);
        Permission::create(['name'=>'Volunteer.destroy']);
        Permission::create(['name'=>'Volunteer.application.form']);
        Permission::create(['name'=>'Volunteer.apply']);
        Permission::create(['name'=>'Volunteer.Screen']);
        Permission::create(['name'=>'Volunteer.email.unverified']);
        Permission::create(['name'=>'Volunteer.verified.applicant']);
        Permission::create(['name'=>'Volunteer.selected']);
        Permission::create(['name'=>'Volunteer.verify.email']);


        Permission::create(['name'=>'User.index']);
        Permission::create(['name'=>'User.show']);
        Permission::create(['name'=>'User.update']);
        Permission::create(['name'=>'User.destroy']);
        Permission::create(['name'=>'User.profile']);
        Permission::create(['name'=>'User.give.permission']);
        Permission::create(['name'=>'User.revoke.permission']);
        Permission::create(['name'=>'User.user.permissions']);
        Permission::create(['name'=>'User.give.all.permission']);
        Permission::create(['name'=>'User.remove.all.permission']);
        Permission::create(['name'=>'User.credential.download']);

        Permission::create(['name'=>'Woreda.index']);
        Permission::create(['name'=>'Woreda.store']);
        Permission::create(['name'=>'Woreda.show']);
        Permission::create(['name'=>'Woreda.update']);
        Permission::create(['name'=>'Woreda.destroy']);
        Permission::create(['name'=>'Woreda.fetch']);
        Permission::create(['name'=>'Woreda.validate.form']);

        Permission::create(['name'=>'Zone.index']);
        Permission::create(['name'=>'Zone.store']);
        Permission::create(['name'=>'Zone.show']);
        Permission::create(['name'=>'Zone.update']);
        Permission::create(['name'=>'Zone.destroy']);
        Permission::create(['name'=>'Zone.fetch']);
        Permission::create(['name'=>'Zone.validate.form']);
        $this->abdi();
        $this->ajaib();
        $this->ms();
    }

    public function abdi()
    {
        Permission::create(['name' => PermissionSeeder::CENTER_COORIDNATOR]);
        Permission::create(['name'=>'Document.index']);
        Permission::create(['name'=>'Document.store']);
        Permission::create(['name'=>'Document.show']);
        Permission::create(['name'=>'Document.update']);
        Permission::create(['name'=>'Document.destroy']);

        Permission::create(['name'=>'TrainingSchedule.index']);
        Permission::create(['name'=>'TrainingSchedule.store']);
        Permission::create(['name'=>'TrainingSchedule.show']);
        Permission::create(['name'=>'TrainingSchedule.update']);
        Permission::create(['name'=>'TrainingSchedule.destroy']);



        Permission::create(['name'=>'HierarchyReport.index']);
        Permission::create(['name'=>'HierarchyReport.list']);
        Permission::create(['name'=>'HierarchyReport.store']);
        Permission::create(['name'=>'HierarchyReport.show']);
        Permission::create(['name'=>'HierarchyReport.update']);
        Permission::create(['name'=>'HierarchyReport.destroy']);

        Permission::create(['name'=>'SyndicationRoom.index']);
        Permission::create(['name'=>'SyndicationRoom.store']);
        Permission::create(['name'=>'SyndicationRoom.placement']);
        Permission::create(['name'=>'SyndicationRoom.show']);
        Permission::create(['name'=>'SyndicationRoom.update']);
        Permission::create(['name'=>'SyndicationRoom.destroy']);

        Permission::create(['name'=>'centerCooridnator.assign']);
    }

    public function ms(){
        Permission::create(['name'=>'RegionIntake.index']);
        Permission::create(['name'=>'RegionIntake.store']);
        Permission::create(['name'=>'Region.deployment']);

        Permission::create(['name'=>'ZoneIntake.index']);
        Permission::create(['name'=>'ZoneIntake.store']);
        Permission::create(['name'=>'ZoneIntake.update']);

        Permission::create(['name'=>'WoredaIntake.index']);
        Permission::create(['name'=>'WoredaIntake.store']);
        Permission::create(['name'=>'WoredaIntake.update']);

        Permission::create(['name'=>'GraduationList.index']);

        Permission::create(['name'=>'CertificateGenerate.index']);
        Permission::create(['name'=>'CertificateGenerate.print']);

        Permission::create(['name'=>'TraininingCenter.checkedInID']);
        Permission::create(['name'=>'TraininingCenter.trainnerID']);
        Permission::create(['name'=>'TraininingCenter.graduate']);
        Permission::create(['name'=>'TraininingCenter.checkedInIDPrint']);
        Permission::create(['name'=>'TraininingCenter.trainnerIDPrint']);
        Permission::create(['name'=>'TraininingCenter.graduatedIDPrint']);

        Permission::create(['name'=>'VolunteerDeployment.zones']);
        Permission::create(['name'=>'VolunteerDeployment.woredas']);
        Permission::create(['name'=>'VolunteerDeployment.attendanceExport']);
        Permission::create(['name'=>'VolunteerDeployment.attendanceImport']);
        Permission::create(['name'=>'VolunteerDeployment.graduate']);
        Permission::create(['name'=>'volunteer.deployment']);
        Permission::create(['name'=>'generate.certificate']);

        Permission::create(['name'=>'region.quota']);
        Permission::create(['name'=>'payroll.list']);
        Permission::create(['name'=>'payroll.report']);
        Permission::create(['name'=>'payment.type']);
        Permission::create(['name'=>'distance.setting']);
        Permission::create(['name'=>'transport.tarif']);
        Permission::create(['name'=>'translation.index']);
    }
    public function ajaib()
    {
        Permission::create(['name'=>'Resource.index']);
        Permission::create(['name'=>'Resource.store']);
        Permission::create(['name'=>'Resource.show']);
        Permission::create(['name'=>'Resource.update']);
        Permission::create(['name'=>'Resource.destroy']);

        Permission::create(['name'=>'Event.index']);
        Permission::create(['name'=>'Event.store']);
        Permission::create(['name'=>'Event.show']);
        Permission::create(['name'=>'Event.update']);


        Permission::create(['name'=>'audit.index']);

        //updating trainingCenter Permission
        Permission::create(['name'=>'TraininingCenter.giveResource']);
        Permission::create(['name'=>'TraininingCenter.giveResourceDetail']);

        //updating trainingSession Permission

        Permission::create(['name'=>'TrainingSession.allResource']);
        Permission::create(['name'=>'TrainingSession.showResource']);

        //adding checked in deployment

        Permission::create(['name'=>'deployment.checkIn']);





    }
}

