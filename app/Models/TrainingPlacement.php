<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPlacement extends Model
{
    use HasFactory;

    protected $fillable = ['training_center_capacity_id', 'approved_applicant_id'];
    protected $append = ['region'];

    public function approvedApplicant()
    {
        return $this->belongsTo(ApprovedApplicant::class, 'approved_applicant_id', 'id');
    }

    public function getRegionAttribute()
    {
        return $this->approvedApplicant->region->id;
    }
}
