<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;
    protected $table = "training_sessions";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'registration_start_date',
        'registration_dead_line',
        'quantity',
        'status'
    ];

    static public function availableSession()
    {
        $today = Carbon::today();
        return TrainingSession::where('registration_start_date', '<=', $today)->where('registration_dead_line', '>=', $today)->get();
    }

    public function quotas(){
        return $this->hasMany(Qouta::class);
    }
}
