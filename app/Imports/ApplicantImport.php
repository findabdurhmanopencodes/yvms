<?php

namespace App\Imports;

use App\Http\Controllers\WoredaController;
use App\Models\ApprovedApplicant;
use App\Models\Region;
use App\Models\Status;
use App\Models\TrainingPlacement;
use App\Models\Volunteer;
use App\Models\Woreda;
use DateTime;
use Illuminate\Support\Collection;
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
    public function collection(Collection $row)
    {
        set_time_limit(1000);
        $aaa = [];
        foreach ($row as $key => $value) {
            $fi_name = '';
            $fathe_name = '';
            $gr_name = '';
            $woredas_app = ltrim(rtrim(strtoupper($value[8])));
            $woreda = Woreda::Where('name', $woredas_app)->get()->first();
            
                $name_val = str_replace('  ', ' ', ltrim(rtrim($value[1])));
                $name = explode(' ',$name_val);
                if (count($name) >= 1) {
                    $fi_name = $name[0];
                }
                if (count($name) >= 2) {
                    $fathe_name = $name[1];
                }
                if (count($name) >= 3) {
                    $gr_name = $name[2];
                }
            if ($value[12] == 'Jimma University') {
                // $gpa = $value[9]||'';
                // $date = strtotime ((string)$value[3]);
                // $d = date('d/m/Y' , $date);
                
                $applicant = new Volunteer();
                $applcant_exist = $applicant->where('first_name', $fi_name)->where('father_name', $fathe_name)->where('grand_father_name', $gr_name)->where('phone', (string)$value[11])->get()->first();

                $app_app = ApprovedApplicant::where('volunteer_id', $applcant_exist->id)->get()->first()->id;
                
                $placed_exist = TrainingPlacement::where('approved_applicant_id', $app_app)->get()->first();

                if ($placed_exist == null) {
                    $placeVol = TrainingPlacement::create(['training_center_capacity_id'=>1, 'approved_applicant_id'=>$app_app, 'training_session_id'=>$this->trainingSession->id]);
                    // Status::where('')
                }

                
                // if ($applcant_exist == null) {
                //     $applicant = Volunteer::create(['first_name' => $fi_name, 'father_name' => $fathe_name, 'grand_father_name'=> $gr_name, 'email'=>'', 'dob'=> new DateTime('01/01/1991'), 'gender'=>$value[2], 'phone'=>(string)$value[11], 'contact_name'=>'UNKNOWN', 'contact_phone'=> 'UNKNOWN', 'gpa'=>$gpa, 'password'=> Hash::make('12345678'),'training_session_id'=>$this->trainingSession->id, 'woreda_id'=>$woreda->id]);
                //     Status::create(['volunteer_id'=> $applicant->id, 'acceptance_status'=>1]);
                // }
                // $applicant->first_name = $fi_name;
                // $applicant->father_name = $fathe_name;
                // $applicant->grand_father_name = $gr_name;
                // $applicant->email = '';
                // $applicant->dob = new DateTime('01/01/1991');
                // $applicant->gender = $value[2];
                // $applicant->phone = (string)$value[11];
                // $applicant->contact_name = 'UNKNOWN';
                // $applicant->contact_phone = 'UNKNOWN';
                // $applicant->gpa = $gpa;
                // $applicant->password = Hash::make('12345678');
                // $applicant->save();

                // $status = new Status();
                // $status->volunteer_id = $applicant->id;
                // $status->acceptance_status = 1;
                // $status->save();

                // $applicant = Volunteer::create(['first_name' => $fi_name, 'father_name' => $fathe_name, 'grand_father_name'=> $gr_name, 'email'=>'', 'dob'=> new DateTime('01/01/1991'), 'gender'=>$value[2], 'phone'=>(string)$value[11], 'contact_name'=>'UNKNOWN', 'contact_phone'=> 'UNKNOWN', 'gpa'=>$gpa, 'password'=> Hash::make('12345678'),'training_session_id'=>$this->trainingSession->id, 'woreda_id'=>$woreda->id]);
                // Status::create(['volunteer_id'=> $applicant->id, 'acceptance_status'=>1]);
            }if ($value[12] == 'Wondo Genet') {
                $applicant = new Volunteer();
                $applcant_exist = $applicant->where('first_name', $fi_name)->where('father_name', $fathe_name)->where('grand_father_name', $gr_name)->where('phone', (string)$value[11])->get()->first();

                if ($applcant_exist) {
                    $app_app = ApprovedApplicant::where('volunteer_id', $applcant_exist->id)->get()->first();
                
                    if ($app_app) {
                        $app_app = $app_app->id;
                        $placed_exist = TrainingPlacement::where('approved_applicant_id', $app_app)->get()->first();

                        if ($placed_exist == null) {
                            $placeVol = TrainingPlacement::create(['training_center_capacity_id'=>3, 'approved_applicant_id'=>$app_app, 'training_session_id'=>$this->trainingSession->id]);
                            // Status::where('')
                        }
                    }
                }

                
            }
        }
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
