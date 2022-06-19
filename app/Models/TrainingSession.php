<?php

namespace App\Models;

use Andegna\DateTimeFactory;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use OwenIt\Auditing\Contracts\Auditable;

class TrainingSession extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
        'training_end_date',
        'end_date_am'
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

    /**
     * Get all of the trainings for the TrainingSession
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function trainingScheduless(): HasManyThrough
    {
        return $this->hasManyThrough(TrainingSchedule::class, Schedule::class, 'training_session_id', 'schedule_id');
    }


    static public function availableSession()
    {
        $today = Carbon::today();
        $ts =  TrainingSession::where('start_date', '<=', $today)->where('end_date', '>=', $today)->get();
        if ($ts->isEmpty())
            $ts = TrainingSession::latest()->limit(1)->get();

        return $ts;
    }
 //////////////////////////////////////////////
    public function startDateET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->start_date))->format('d/m/Y');
    }

    public function endDateET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->end_date))->format('d/m/Y');
    }
///////////////////////////////////////////////////
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
////////////////////////////////////////////////
    public function sessionRegions()
    {
        return $this->hasMany(SessionRegion::class);
    }
///////////////////////////////////////////////
    public function sessionZones()
    {
        return $this->hasMany(SessionRegion::class);
    }

    public function payroll()
{
    return $this->hasMany(Payroll::class);
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

    public function trainingEndDateET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->training_end_date))->format('d/m/Y');
    }

    public function attendances(){
        return $this->hasMany(DeploymentVolunteerAttendance::class);
    }

    public function dateDiff(){
        $diff = abs(strtotime($this->training_end_date) - strtotime($this->training_start_date));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        
        return $years.','.$months.','.$days;
    }
}
