<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function trainner(TrainingSession $trainingSession,TraininingCenter $trainingCenter,Training $training)
    {
        return TrainingMasterPlacement::where('training_session_id',$trainingSession->id)->where('trainining_center_id',$trainingCenter->id)->where('training_id',$training->id)->first();
    }
}
