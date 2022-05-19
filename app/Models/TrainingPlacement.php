<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingPlacement extends Model
{
    use HasFactory;

    protected $fillable = ['training_center_capacity_id', 'approved_applicant_id', 'training_session_id'];
    protected $append = ['region'];

    public function approvedApplicant()
    {
        return $this->belongsTo(ApprovedApplicant::class, 'approved_applicant_id', 'id');
    }
    public function trainingCenterCapacity()
    {
        return $this->belongsTo(TrainingCenterCapacity::class, 'training_center_capacity_id', 'id');
    }

    public function getRegionAttribute()
    {
        return $this->approvedApplicant->region->id;
    }

    public function session()
    {
        return $this->belongsTo(TrainingSession::class, 'training_session_id', 'id');
    }
}
