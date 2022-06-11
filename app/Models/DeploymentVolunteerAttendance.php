<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeploymentVolunteerAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'training_session_id','woreda_id', 'attendance_date', 'volunteers' 
    ];

    public function woreda()
    {
        return $this->belongsTo(Woreda::class);
    }

    public function session()
    {
        return $this->belongsTo(TrainingSession::class);
    }
}
