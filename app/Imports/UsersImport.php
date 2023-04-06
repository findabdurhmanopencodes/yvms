<?php

namespace App\Imports;

use App\Models\Schedule;
use App\Models\TrainingSchedule;
use App\Models\TrainingSessionTraining;
use App\Models\User;
use App\Models\UserAttendance;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToCollection,  WithStartRow
{
    protected $trainingSession, $trainingCenter, $cindicationRoom;

    public function __construct($trainingSession, $trainingCenter, $cindicationRoom)
    {
        $this->trainingSession = $trainingSession;
        $this->trainingCenter = $trainingCenter;
        $this->cindicationRoom = $cindicationRoom;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $row)
    {
        $schedule = Schedule::where('id', $row[0][5])->get()[0];
        $arr = [];
        foreach ($row as $key => $ro) {
            array_push($arr, $ro);
        }
        array_shift($arr);
        foreach ($arr as $key => $value) {
            
            if ($schedule->checkDateAtt() == true) {
                $training_schedule_id = TrainingSchedule::whereIn('training_session_training_id', TrainingSessionTraining::where('training_session_id', $this->trainingSession->id)->pluck('id'))->where('schedule_id', $schedule->id)->get()[0]->id;
                // dd($training_schedule_id);
                
                $user_id = User::whereRelation('volunteer', 'id_number', $value[0])->get()[0]->id;

                $checkifExists = UserAttendance::where('user_id',$user_id)->where('training_schedule_id',$training_schedule_id)->get();

                if (!$checkifExists->first()) {
                    if ($value[4] == 'P') {
                        UserAttendance::create(['user_id' => $user_id, 'training_schedule_id' => $training_schedule_id]);
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
        return 1;
    }
}
