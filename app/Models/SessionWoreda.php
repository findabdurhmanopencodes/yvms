<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SessionWoreda extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


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
