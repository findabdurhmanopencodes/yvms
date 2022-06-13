<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SessionZone extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


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
