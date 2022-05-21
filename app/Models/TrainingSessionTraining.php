<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingSessionTraining extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the training that owns the TrainingSessionTraining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    /**
     * Get the trainingSession that owns the TrainingSessionTraining
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }
}
