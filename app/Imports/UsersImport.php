<?php

namespace App\Imports;

use App\Models\Schedule;
use App\Models\TrainingSchedule;
use App\Models\TrainingSessionTraining;
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
        // dd('sdfsd');
        foreach ($row as $key => $value) {
            foreach (Schedule::where('training_session_id', $this->trainingSession->id)->get() as $key => $val) {
                if ($val->checkDateAtt() == true && $val->shift == 1) {
                    $training_schedule_id = TrainingSchedule::where('training_session_training_id', TrainingSessionTraining::where('training_session_id', $this->trainingSession->id)->pluck('id'))->where('schedule_id', $val->id)->get()[0]->id;

                    $checkifExists = UserAttendance::where('user_id',$value[0])->where('training_schedule_id',$training_schedule_id)->get();

                    if (!$checkifExists->first()) {
                        if ($value[2] == 'P') {
                            UserAttendance::create(['user_id' => $value[0], 'training_schedule_id' => $training_schedule_id]);
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
