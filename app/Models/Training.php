<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Training extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function trainner(TrainingSession $trainingSession,TraininingCenter $trainingCenter,CindicationRoom $cindicationRoom)
    {
        return TrainingMasterPlacement::where('training_session_id',$trainingSession->id)->where('trainining_center_id',$trainingCenter->id)->where('cindication_room_id',$cindicationRoom->id)->where('training_id',$this->id)->first();
    }
}
