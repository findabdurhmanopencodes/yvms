<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCenterCapacity extends Model
{
    use HasFactory;
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
        return $this->belongsTo(TrainingSession::class,'trainining_center_id', 'id');
    }
}
