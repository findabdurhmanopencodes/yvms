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
        'region_id'
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

}
