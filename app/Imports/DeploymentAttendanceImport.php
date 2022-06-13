<?php

namespace App\Imports;

use App\Models\DeploymentVolunteerAttendance;
use App\Models\Volunteer;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DeploymentAttendanceImport implements ToCollection, WithStartRow
{
    protected $trainingSession, $woreda;

    public function __construct($trainingSession, $woreda)
    {
        $this->trainingSession = $trainingSession;
        $this->woreda = $woreda;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        $date_now = new DateTime();
        $volunteer_id = [];
        $check_exist = [];
        $past_url = url()->previous();
        foreach ($collection as $key => $value) {
            if ($value[4] == 'P') {
                array_push($volunteer_id, $value[0]);
            }
        }

        foreach (DeploymentVolunteerAttendance::all() as $key => $value) {
            if (($value->training_session_id == $this->trainingSession->id) && ($value->woreda_id == $this->woreda->id) && ($value->attendance_date == $date_now->format('Y-m-d'))) {
                array_push($check_exist, $value);
            }
        }

        if (!$check_exist) {
            DeploymentVolunteerAttendance::create(['training_session_id'=> $this->trainingSession->id, 'woreda_id'=>$this->woreda->id, 'attendance_date'=>$date_now, 'volunteers'=> json_encode($volunteer_id)]);
            return redirect($past_url)->with('error', 'Volunteer Attendance Added Successfully!!!');
        }else{
            return redirect($past_url)->with('error', 'Attendance Already Exists!!');
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