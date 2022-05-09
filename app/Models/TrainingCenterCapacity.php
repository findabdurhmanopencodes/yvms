<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCenterCapacity extends Model
{
    use HasFactory;
    protected $fillable=['trainining_center_id','capacity','training_session_id'];

    public function trainingCenters()
    {
        return $this->hasMany(TraininingCenter::class);
    }
    public function trainningSession()
    {
        return $this->hasMany(TrainingSession::class);
    }
}
