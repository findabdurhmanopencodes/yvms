<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $table = "zones";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'region_id',
        'qoutaInpercent',
        'status'
    ];


    public function woredas(){
        return $this->hasMany(Woreda::class);
    }
    public function trainingCenters(){
        return $this->hasMany(TraininingCenter::class);
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function quotas(){
        return $this->morphMany(Qouta::class, 'quotable');
    }
    public function distances(){
        return $this->hasMany(Distance::class);
    }

    public function level(){
        return $this->morphOne(UserRegion::class, 'levelable');
    }

    public function sessionZones(){
        return $this->hasMany(SessionZone::class);
    }

    public function zoneIntakes(){
        return $this->hasMany(ZoneIntake::class);
    }

}
