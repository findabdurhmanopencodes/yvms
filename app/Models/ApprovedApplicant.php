<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedApplicant extends Model
{
    use HasFactory;

    protected $table = "approved_applicants";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'training_session_id',
        'volunteer_id',
        'status',
    ];

    protected $append = ['region'];

    public function trainingPlacements()
    {
        return $this->hasMany(TrainingPlacement::class, 'approved_applicant_id', 'id');
    }

    public function getRegionAttribute()
    {
        return $this->volunteer->woreda->zone->region;
    }

    public function trainingSessionId()
    {
        return $this->belongsTo(TrainingSession::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
}
