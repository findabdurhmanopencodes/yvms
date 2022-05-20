<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraininingCenter extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'logo', 'zone_id'];

    protected $append = ['region'];
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function getRegionAttribute()
    {
        return $this->zone->region;
    }

    public function capacities()
    {
        return $this->hasMany(TrainingCenterCapacity::class,'trainining_center_id', 'id');
    }

}
