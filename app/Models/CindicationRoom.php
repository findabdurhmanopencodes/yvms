<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CindicationRoom extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the trainingCenter that owns the CindicationRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trainingCenter(): BelongsTo
    {
        return $this->belongsTo(TraininingCenter::class, 'trainining_center_id', 'id');
    }

    /**
     * Get all of the volunteers for the CindicationRoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function volunteers(): HasMany
    {
        return $this->hasMany(Volunteer::class);
    }
}
