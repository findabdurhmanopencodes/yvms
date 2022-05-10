<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifyVolunteer extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the volunteer that owns the VerifyVolunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }
}
