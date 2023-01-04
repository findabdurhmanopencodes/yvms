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
        // dd($rows);
        foreach ($rows as $value) {
            // dump($value[7]);
            if (count($value) > 12) {
                if (!FeildOfStudy::where('name',$value[6])->first()) {
                    if ($value[6]) {
                        $feildOfStudy = FeildOfStudy::create(['name'=>$value[6]]);
                    }
                }else{
                    $feildOfStudy = FeildOfStudy::where('name',$value[6])->first();
                }
                if (!Disablity::where('name',$value[12])->first()) {
                    if ($value[12]) {
                        $disability = Disablity::create(['name'=>$value[12]]);
                    }
                }else{
                    $disability = Disablity::where('name',$value[12])->first();
                }
            }
            $gen = $value[4] ?? null;
            $woreda = $value[11] ?? null;
            $woreda_id = Woreda::where('name', $woreda)?->first()?->id;
            $gender = $gen == 'Male' ? 'M' : 'F';

            $first_name = $value[1] ?? null;
            $middle_name = $value[2] ?? null;
            $last_name = $value[3] ?? null;
            $email = $value[14] ?? null;
            $dob = $value[5] ?? null;
            $contact_name = $value[15] ?? null;
            $contact_phone = $value[16] ?? null;
            $gpa = $value[8] ?? null;
            $phone = $value[13] ?? null;

            if ($woreda_id) {
                $user = new User();
                $user->first_name = $first_name;
                $user->father_name = $middle_name;
                $user->grand_father_name = $last_name;
                $user->email = $email;
                $user->dob = $dob;
                $user->gender = $gender;
                $user->save();
                
                $volunteer = new Volunteer();
                $volunteer->first_name = $first_name;
                $volunteer->father_name = $middle_name;
                $volunteer->grand_father_name = $last_name;
                $volunteer->email = $email;
                $volunteer->dob = $dob;
                $volunteer->gender = $gender;
                $volunteer->phone = $phone;
                $volunteer->contact_name = $contact_name;
                $volunteer->contact_phone = $contact_phone;
                $volunteer->gpa = $gpa;
                $volunteer->woreda_id = $woreda_id;
                $volunteer->user_id = $user->id;
                $volunteer->training_session_id = $this->trainingSession->id;
                $volunteer->field_of_study_id  = $feildOfStudy->id;
                $volunteer->educational_level = $edulcationLevel->id;
                $volunteer->disablity_id = $disability->id;
                $volunteer->save();

                $status = new Status();
                $status->volunteer_id = $volunteer->id;
                $status->acceptance_status = Constants::VOLUNTEER_STATUS_PENDING;
                $status->save();
            }
        }
        // dd('dsfds');
    }
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
