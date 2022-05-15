<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionWoreda extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'woreda_id',
        'training_session_id',
        'qoutaInpercent',
    ];

    public function woreda(){
        return $this->belongsTo(Woreda::class);
    }

    public function trainingSession(){
        return $this->belongsTo(TrainingSession::class);
    }
}
