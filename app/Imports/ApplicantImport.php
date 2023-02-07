<?php

namespace App\Imports;

use App\Constants;
use App\Http\Controllers\WoredaController;
use App\Models\ApprovedApplicant;
use App\Models\Disablity;
use App\Models\EducationalLevel;
use App\Models\FeildOfStudy;
use App\Models\Region;
use App\Models\Status;
use App\Models\TrainingPlacement;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Woreda;
use App\Models\Zone;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ApplicantImport implements ToCollection, WithStartRow
{
    protected $trainingSession;
    public function __construct($trainingSession)
    {
        $this->trainingSession = $trainingSession;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        set_time_limit(2000);
        foreach ($rows as $key => $row) {
            $first_name = $row[1]??'UNKNOWN';
            $middle_name = $row[2]??'UNKNOWN';
            $last_name = $row[3]??'UNKNOWN';
            $gender = $row[4] == 'Male' ? 'M' : 'F';
            $dob = $row[5]??'UNKNOWN';
            $field_of_study = $row[6]??'Other';
            $educational_level = $row[7];
            $gpa = $row[8]??'3';
            $region = $row[9];
            $zone = $row[10];
            $woreda = $row[11]??'UNKNOWN';
            $phone = $row[13]??'UNKNOWN';

            $check_field = FeildOfStudy::where('name', $field_of_study)->first();
            if (!$check_field) {
                $field_id = FeildOfStudy::create(['name'=>$field_of_study]);
                $field_of_study_id = $field_id->id;
            }else{
                $field_of_study_id = $check_field->id;
            }

            $check_region = Region::where('name', $region)->first();
            if (!$check_region) {
                $region_id = Region::create(['name'=>$region, 'code'=>substr($region, 0, 3), 'status'=>1]);
                $zone_id = Zone::create(['name'=> $zone, 'code'=>substr($zone, 0, 3), 'region_id'=>$region_id->id, 'status'=>1]);
                $woreda_id = Woreda::create(['name'=>$woreda, 'code'=>substr($woreda, 0, 3), 'zone_id'=>$zone_id->id, 'status'=>1]);
            }else{
                $check_zone = Zone::where('name', $zone)->where('region_id', $check_region->id)->first();
                if (!$check_zone) {
                    $zone_id = Zone::create(['name'=>$zone, 'code'=>substr($zone, 0, 3), 'region_id'=>$check_region->id, 'status'=>1]);
                    $woreda_id = Woreda::create(['name'=>$woreda, 'code'=>substr($woreda, 0, 3), 'zone_id'=>$zone_id->id, 'status'=>1]);
                }else{
                    $check_woreda = Woreda::where('name', $woreda)->where('zone_id', $check_zone->id)->first();
                    if (!$check_woreda) {
                        $woreda_id = Woreda::create(['name'=>$woreda, 'code'=>substr($woreda, 0, 3), 'zone_id'=>$check_zone->id, 'status'=>1]);
                    }else{
                        $woreda_id = $check_woreda;
                    }
                }
            }

            $email_key = count(Volunteer::all());
            $password = Hash::make(substr($first_name, 0, 2).''.substr($middle_name, 0, 2).''.substr($last_name, 0, 2).''.$dob);

            $user_id = User::create(['first_name'=>$first_name, 'father_name'=>$middle_name, 'grand_father_name'=>$last_name, 'email'=>'unknown'.$email_key++.'@unknown.unknown', 'dob'=>$dob, 'gender'=>$gender, 'password'=>$password]);

            $volunteer_id = Volunteer::create(['first_name'=>$first_name, 'father_name'=>$middle_name, 'grand_father_name'=>$last_name, 'email'=>'unknown'.$email_key++.'@unknown.unknown', 'dob'=>$dob, 'gender'=>$gender, 'phone'=>$phone, 'contact_name'=>'UNKNOWN UNKNOWN', 'contact_phone'=>'UNKNOWN', 'gpa'=>$gpa, 'password'=>$password, 'educational_level'=>0, 'user_id'=>$user_id->id, 'training_session_id'=>$this->trainingSession->id, 'field_of_study_id'=>$field_of_study_id, 'woreda_id'=>$woreda_id->id]);

            Status::create(['volunteer_id'=>$volunteer_id->id]);
        }
    }
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 1;
    }
}
