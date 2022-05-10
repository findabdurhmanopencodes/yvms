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
        'qoutaInpercent'
    ];

    protected $append = ['quotasInNumber'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function getRegionAttribute()
    {
        return $this->zone->region->id;
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
}
