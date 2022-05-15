<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionRegion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'region_id',
        'training_session_id',
        'qoutaInpercent',
    ];

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function trainingSession(){
        return $this->belongsTo(TrainingSession::class);
    }
}
