<?php

namespace App\Models;

use Andegna\DateTimeFactory;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class VolunteerDeployment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['woreda_intake_id', 'training_placement_id', 'issued_date_am'];

    public function trainingPlacement(): BelongsTo
    {
        return $this->belongsTo(TrainingPlacement::class, 'training_placement_id', 'id');
    }

    public function woredaIntake(): BelongsTo
    {
        return $this->belongsTo(WoredaIntake::class, 'woreda_intake_id', 'id');
    }

    public function IssuedDate()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->created_at))->format('d/m/Y');
    }
}
