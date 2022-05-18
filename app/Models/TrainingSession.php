<?php

namespace App\Models;

use Andegna\DateTimeFactory;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingSession extends Model
{
    use HasFactory;
    protected $table = "training_sessions";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'registration_start_date',
        'registration_dead_line',
        'quantity',
        'status',
        'moto',
        'training_start_date',
        'training_end_date'
    ];
    protected $append = ['sessionQouta'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_start_date' => 'date',
        'registration_dead_line' => 'date',
        'training_start_date' => 'date',
        'training_end_date' => 'date',
    ];


    static public function availableSession()
    {
        $today = Carbon::today();
        return TrainingSession::where('start_date', '<=', $today)->where('end_date', '>=', $today)->get();
    }
    public function startDateET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->start_date))->format('d/m/Y');
    }

    public function endDateET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->end_date))->format('d/m/Y');
    }

    public function startRegDateET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->registration_start_date))->format('d/m/Y');
    }

    public function endRegDateET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->registration_dead_line))->format('d/m/Y');
    }

    static public function availableForRegistration()
    {
        $today = Carbon::today();
        return TrainingSession::where('registration_start_date', '<=', $today)->where('registration_dead_line', '>=', $today)->get();
    }

    public function getSessionQuotaAttribute()
    {
        return TrainingCenterCapacity::selectRaw('SUM(capacity) as totalQouta')->where(['training_session_id' => $this->id])->groupBy(['training_session_id'])->first()->totalQouta;
    }

    public function quotas()
    {
        return $this->hasMany(Qouta::class);
    }

    public function approvedApplicants()
    {
        return $this->hasMany(ApprovedApplicant::class);
    }
    public function capacities()
    {
        return $this->hasMany(TrainingCenterCapacity::class);
    }

    public function trainingPlacements()
    {
        return $this->hasMany(TrainingPlacement::class, 'training_session_id', 'id');
    }

    public function sessionRegions()
    {
        return $this->hasMany(SessionRegion::class);
    }

    public function sessionZones()
    {
        return $this->hasMany(SessionRegion::class);
    }

    public function sessionWoredas()
    {
        return $this->hasMany(SessionRegion::class);
    }

    /**
     * Get all of the schedules for the TrainingSession
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
