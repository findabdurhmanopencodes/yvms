<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DeploymentVolunteerAttendance extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
