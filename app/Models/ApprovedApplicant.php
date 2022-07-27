<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class ApprovedApplicant extends Model implements Auditable

{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


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

    public function trainingPlacement()
    {
        return $this->hasOne(TrainingPlacement::class, 'approved_applicant_id', 'id');
    }

    public function getRegionAttribute()
    {
        return $this->volunteer?->woreda?->zone?->region;
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
