<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Volunteer extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
     * Get the user that owns the Volunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Get the woreda associated with the Volunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function woreda(): HasOne
    {
        return $this->hasOne(Woreda::class,'id','woreda_id');
    }
}
