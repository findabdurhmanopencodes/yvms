<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TrainingCenterCapacity extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['trainining_center_id', 'capacity', 'training_session_id'];
    protected $append = ['region'];

    public function getRegionAttribute()
    {
        return $this->trainingCenter->zone->region;
    }
    public function trainingCenter()
    {
        return $this->belongsTo(TraininingCenter::class, 'trainining_center_id', 'id');
    }
    public function trainningSession()
    {
        return $this->belongsTo(TrainingSession::class,'training_session_id', 'id');
    }
}
