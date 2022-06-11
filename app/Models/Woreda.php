<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Woreda extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'zone_id',
        'qoutaInpercent',
        'status'
    ];

    protected $append = ['quotasInNumber'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function reports(){
        return $this->morphMany(HierarchyReport::class, 'reportable');
    }


    public function getRegionAttribute()
    {
        return $this->zone->region;
    }
    public function getIntakeAttribute()
    {
        $session = TrainingSession::availableSession()->first();
        return $this->woredaIntakes()->where(['training_session_id' => $session->id])->first()->intake;
    }

    public function getQuotasInNumberAttribute()
    {
        $countWoredas =  Woreda::count();

        return TrainingSession::availableSession()->first()->sessionQouta / $countWoredas;
    }

    public function quotas()
    {
        return $this->morphMany(Qouta::class, 'quotable');
    }
    public function applicants()
    {
        return $this->hasMany(Volunteer::class);
    }

    public function sessionWoredas()
    {
        return $this->hasMany(SessionWoreda::class);
    }

    public function woredaIntakes()
    {
        return $this->hasMany(WoredaIntake::class);
    }

    public function attendances(){
        return $this->hasMany(DeploymentVolunteerAttendance::class);
    }
}
