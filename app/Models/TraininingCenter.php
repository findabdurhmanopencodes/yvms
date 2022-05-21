<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    /**
     * Get the photo that owns the TraininingCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo(): BelongsTo
    {
        return $this->belongsTo(File::class, 'logo', 'id');
    }


    public function getLogo()
    {
        return $this->photo?->file_path ?? asset('user.png');
    }

    public function capacities()
    {
        return $this->hasMany(TrainingCenterCapacity::class, 'trainining_center_id', 'id');
    }
    public function checkers()
    {
        return $this->hasMany(User::class);
    }
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_trainining', 'trainining_center_id', 'resource_id')->withPivot('current_balance', 'initial_balance');
    }
}
