<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionZone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'zone_id',
        'training_session_id',
        'qoutaInpercent',
    ];

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function trainingSession(){
        return $this->belongsTo(TrainingSession::class);
    }
}
