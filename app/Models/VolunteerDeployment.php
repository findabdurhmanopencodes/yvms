<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerDeployment extends Model
{
    use HasFactory;

    protected $fillable = ['woreda_intake_id', 'training_placement_id'];

    public function trainingPlacement(): BelongsTo
    {
        return $this->belongsTo(TrainingPlacement::class, 'training_placement_id', 'id');
    }

    public function woredaIntake(): BelongsTo
    {
        return $this->belongsTo(WoredaIntake::class, 'woreda_intake_id', 'id');
    }
}
