<?php

namespace App\Models;

use Andegna\DateTimeFactory;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the trainingSession that owns the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get all of the trainings for the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(TrainingSchedule::class);
    }

    public function getShiftOptions()
    {
        return [
            0 => 'Morining',
            1 => 'Afternoon',
            2 => 'Both'
        ];
    }

    public function dateET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->date))->format('d/m/Y');
    }
    
    public function checkDateAtt()
    {
        $check_date_att = false;
        $date_now_et = DateTimeFactory::fromDateTime(new DateTime(Carbon::now()))->format('d/m/Y');
        
        if ($this->dateET() == $date_now_et) {
            $check_date_att = true;
        }
        return $check_date_att;
    }

}
