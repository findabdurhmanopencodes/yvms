<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SessionRegion extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


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
