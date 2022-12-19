<?php

namespace Database\Seeders;

use App\Constants;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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


        Permission::findOrCreate('dashboard.index');

        Permission::findOrCreate('Disablity.index');
        Permission::findOrCreate('Disablity.store');
        Permission::findOrCreate('Disablity.show');
        Permission::findOrCreate('Disablity.update');
        Permission::findOrCreate('Disablity.destroy');

        Permission::findOrCreate('EducationalLevel.index');
        Permission::findOrCreate('EducationalLevel.store');
        Permission::findOrCreate('EducationalLevel.show');
        Permission::findOrCreate('EducationalLevel.update');
        Permission::findOrCreate('EducationalLevel.destroy');

        Permission::findOrCreate('Feadback.index');
        Permission::findOrCreate('Feadback.store');
        Permission::findOrCreate('Feadback.show');
        Permission::findOrCreate('Feadback.update');
        Permission::findOrCreate('Feadback.destroy');

        Permission::findOrCreate('FeildOfStudy.index');
        Permission::findOrCreate('FeildOfStudy.store');
        Permission::findOrCreate('FeildOfStudy.show');
        Permission::findOrCreate('FeildOfStudy.update');
        Permission::findOrCreate('FeildOfStudy.destroy');

        Permission::findOrCreate('File.file.Upload');

        Permission::findOrCreate('Permission.index');
        Permission::findOrCreate('Permission.store');
        Permission::findOrCreate('Permission.show');
        Permission::findOrCreate('Permission.update');
        Permission::findOrCreate('Permission.destroy');

        Permission::findOrCreate('Qouta.index');
        Permission::findOrCreate('Qouta.store');
        Permission::findOrCreate('Qouta.show');
        Permission::findOrCreate('Qouta.update');
        Permission::findOrCreate('Qouta.destroy');


        Permission::findOrCreate('Region.index');
        Permission::findOrCreate('Region.store');
        Permission::findOrCreate('Region.show');
        Permission::findOrCreate('Region.update');
        Permission::findOrCreate('Region.destroy');
        Permission::findOrCreate('Region.place');
        Permission::findOrCreate('Region.validate.form');

        Permission::findOrCreate('Role.index');
        Permission::findOrCreate('Role.store');
        Permission::findOrCreate('Role.show');
        Permission::findOrCreate('Role.update');
        Permission::findOrCreate('Role.destroy');
        Permission::findOrCreate('Role.permissions');
        Permission::findOrCreate('Role.give.permission');
        Permission::findOrCreate('Role.revoke.permission');
        Permission::findOrCreate('Role.give.all.Permission');
        Permission::findOrCreate('Role.remove.all.Permission');

        Permission::findOrCreate('TrainingCenterCapacity.index');
        Permission::findOrCreate('TrainingCenterCapacity.store');
        Permission::findOrCreate('TrainingCenterCapacitq.show');
        Permission::findOrCreate('TrainingCenterCapacity.update');
        Permission::findOrCreate('TrainingCenterCapacity.destroy');
        Permission::findOrCreate('TrainingCenterCapacity.capacity.Change');


        Permission::findOrCreate('TrainingMaster.index');
        Permission::findOrCreate('TrainingMaster.store');
        Permission::findOrCreate('TrainingMaster.show');
        Permission::findOrCreate('TrainingMaster.update');
        Permission::findOrCreate('TrainingMaster.destroy');


        Permission::findOrCreate('Training.index');
        Permission::findOrCreate('Training.store');
        Permission::findOrCreate('Training.show');
        Permission::findOrCreate('Training.update');
        Permission::findOrCreate('Training.destroy');

        Permission::findOrCreate('TrainingPlacement.index');
        Permission::findOrCreate('TrainingPlacement.store');
        Permission::findOrCreate('TrainingPlacement.show');
        Permission::findOrCreate('TrainingPlacement.update');
        Permission::findOrCreate('TrainingPlacement.destroy');

        Permission::findOrCreate('TrainingSession.index');
        Permission::findOrCreate('TrainingSession.store');
        Permission::findOrCreate('TrainingSession.show');
        Permission::findOrCreate('TrainingSession.destroy');
        Permission::findOrCreate('TrainingSession.update');
        Permission::findOrCreate('TrainingSession.show.quota');
        Permission::findOrCreate('TrainingSession.screen');

        Permission::findOrCreate('TraininingCenter.index');
        Permission::findOrCreate('TraininingCenter.store');
        Permission::findOrCreate('TraininingCenter.show');
        Permission::findOrCreate('TraininingCenter.update');
        Permission::findOrCreate('TraininingCenter.destroy');
        Permission::findOrCreate('TraininingCenter.placement');

        Permission::findOrCreate('UserRegion.index');
        Permission::findOrCreate('UserRegion.store');
        Permission::findOrCreate('UserRegion.show');
        Permission::findOrCreate('UserRegion.update');
        Permission::findOrCreate('UserRegion.destroy');


        Permission::findOrCreate('Volunteer.index');
        Permission::findOrCreate('Volunteer.store');
        Permission::findOrCreate('Volunteer.show');
        Permission::findOrCreate('Volunteer.update');
        Permission::findOrCreate('Volunteer.destroy');
        Permission::findOrCreate('Volunteer.application.form');
        Permission::findOrCreate('Volunteer.apply');
        Permission::findOrCreate('Volunteer.Screen');
        Permission::findOrCreate('Volunteer.email.unverified');
        Permission::findOrCreate('Volunteer.verified.applicant');
        Permission::findOrCreate('Volunteer.selected');
        Permission::findOrCreate('Volunteer.verify.email');


        Permission::findOrCreate('User.index');
        Permission::findOrCreate('User.show');
        Permission::findOrCreate('User.update');
        Permission::findOrCreate('User.destroy');
        Permission::findOrCreate('User.profile');
        Permission::findOrCreate('User.give.permission');
        Permission::findOrCreate('User.revoke.permission');
        Permission::findOrCreate('User.user.permissions');
        Permission::findOrCreate('User.give.all.permission');
        Permission::findOrCreate('User.remove.all.permission');
        Permission::findOrCreate('User.credential.download');

        Permission::findOrCreate('Woreda.index');
        Permission::findOrCreate('Woreda.store');
        Permission::findOrCreate('Woreda.show');
        Permission::findOrCreate('Woreda.update');
        Permission::findOrCreate('Woreda.destroy');
        Permission::findOrCreate('Woreda.fetch');
        Permission::findOrCreate('Woreda.validate.form');

        Permission::findOrCreate('Zone.index');
        Permission::findOrCreate('Zone.store');
        Permission::findOrCreate('Zone.show');
        Permission::findOrCreate('Zone.update');
        Permission::findOrCreate('Zone.destroy');
        Permission::findOrCreate('Zone.fetch');
        Permission::findOrCreate('Zone.validate.form');
        $this->abdi();
        $this->ajaib();
        $this->ms();
//        $this->seid();
    }



    public function abdi()
    {
        Permission::findOrCreate(PermissionSeeder::CENTER_COORIDNATOR);
        Permission::findOrCreate('Document.index');
        Permission::findOrCreate('Document.store');
        Permission::findOrCreate('Document.show');
        Permission::findOrCreate('Document.update');
        Permission::findOrCreate('Document.destroy');

        Permission::findOrCreate('TrainingSchedule.index');
        Permission::findOrCreate('TrainingSchedule.store');
        Permission::findOrCreate('TrainingSchedule.show');
        Permission::findOrCreate('TrainingSchedule.update');
        Permission::findOrCreate('TrainingSchedule.destroy');



        Permission::findOrCreate('HierarchyReport.index');
        Permission::findOrCreate('HierarchyReport.list');
        Permission::findOrCreate('HierarchyReport.store');
        Permission::findOrCreate('HierarchyReport.show');
        Permission::findOrCreate('HierarchyReport.update');
        Permission::findOrCreate('HierarchyReport.destroy');

        Permission::findOrCreate('SyndicationRoom.index');
        Permission::findOrCreate('SyndicationRoom.store');
        Permission::findOrCreate('SyndicationRoom.placement');
        Permission::findOrCreate('SyndicationRoom.show');
        Permission::findOrCreate('SyndicationRoom.update');
        Permission::findOrCreate('SyndicationRoom.destroy');

        Permission::findOrCreate('centerCooridnator.assign');
    }

    public function ms()
    {
        Permission::findOrCreate('RegionIntake.index');
        Permission::findOrCreate('RegionIntake.store');
        Permission::findOrCreate('Region.deployment');

        Permission::findOrCreate('ZoneIntake.index');
        Permission::findOrCreate('ZoneIntake.store');
        Permission::findOrCreate('ZoneIntake.update');

        Permission::findOrCreate('WoredaIntake.index');
        Permission::findOrCreate('WoredaIntake.store');
        Permission::findOrCreate('WoredaIntake.update');

        Permission::findOrCreate('GraduationList.index');

        Permission::findOrCreate('CertificateGenerate.index');
        Permission::findOrCreate('CertificateGenerate.print');

        Permission::findOrCreate('TraininingCenter.checkedInID');
        Permission::findOrCreate('TraininingCenter.trainnerID');
        Permission::findOrCreate('TraininingCenter.graduate');
        Permission::findOrCreate('TraininingCenter.checkedInIDPrint');
        Permission::findOrCreate('TraininingCenter.trainnerIDPrint');
        Permission::findOrCreate('TraininingCenter.graduatedIDPrint');

        Permission::findOrCreate('VolunteerDeployment.zones');
        Permission::findOrCreate('VolunteerDeployment.woredas');
        Permission::findOrCreate('VolunteerDeployment.attendanceExport');
        Permission::findOrCreate('VolunteerDeployment.attendanceImport');
        Permission::findOrCreate('VolunteerDeployment.graduate');
        Permission::findOrCreate('volunteer.deployment');
        Permission::findOrCreate('generate.certificate');

        Permission::findOrCreate('region.quota');
        Permission::findOrCreate('payroll.list');
        Permission::findOrCreate('payroll.report');
        Permission::findOrCreate('payment.type');
        Permission::findOrCreate('distance.setting');
        Permission::findOrCreate('transport.tarif');
        Permission::findOrCreate('translation.index');
    }
    public function ajaib()
    {
        Permission::findOrCreate('Resource.index');
        Permission::findOrCreate('Resource.store');
        Permission::findOrCreate('Resource.show');
        Permission::findOrCreate('Resource.update');
        Permission::findOrCreate('Resource.destroy');

        Permission::findOrCreate('Event.index');
        Permission::findOrCreate('Event.store');
        Permission::findOrCreate('Event.show');
        Permission::findOrCreate('Event.update');
        Permission::findOrCreate('audit.index');
        //updating trainingCenter Permission
        Permission::findOrCreate('TraininingCenter.giveResource');
        Permission::findOrCreate('TraininingCenter.giveResourceDetail');
        //updating trainingSession Permission
        Permission::findOrCreate('TrainingSession.allResource');
        Permission::findOrCreate('TrainingSession.showResource');
    }

    public function seid()
    {
        $permissionOfPayroll = [
            'Payroll.index','Payroll.view','Payroll.findOrCreate','Payroll.edit',
            'Payroll.delete', 'PayrollSheet.view', 'PayrollSheet.findOrCreate',
            'PayrollSheet.edit', 'PayrollSheet.delete',
            'Payroll.filter',  'PayrollSheet.filter',  'Payroll.print',
            'PaymentType.index', 'PaymentType.edit', 'PaymentType.delete',
            'PaymentType.findOrCreate', 'Distance.index',  'Distance.findOrCreate',
            'Distance.edit', 'Distance.delete', 'Distance.import', 'TransportTarif.index',
             'TransportTarif.findOrCreate',  'TransportTarif.edit', 'TransportTarif.delete'
        ];
        foreach($permissionOfPayroll as $payrollPermission){
            Permission::findOrCreate($payrollPermission);
        }
        try {
            Role::findOrCreate(Constants::SUPER_ADMIN)->givePermissionTo([
                'Payroll.index', 'Payroll.view', 'Payroll.findOrCreate', 'Payroll.edit',
                'Payroll.delete', 'PayrollSheet.view', 'PayrollSheet.findOrCreate',
                'PayrollSheet.edit', 'PayrollSheet.delete',  'Payroll.report',
                'Payroll.filter',  'PayrollSheet.filter',  'Payroll.print',
                'PaymentType.index', 'PaymentType.edit', 'PaymentType.delete',
                'PaymentType.findOrCreate', 'Distance.index',  'Distance.findOrCreate',
                'Distance.edit', 'Distance.delete', 'Distance.import', 'TransportTarif.index',
                'TransportTarif.findOrCreate',  'TransportTarif.edit', 'TransportTarif.delete'
            ]);
        } catch (Exception $f) {
            // Permission::findOrCreate(explode('`', $f->getMessage())[1]);
        }
        Permission::findOrCreate('deployment.checkIn');
    }
}
