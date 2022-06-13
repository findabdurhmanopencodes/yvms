<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Qouta extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'quantity',
        'quotable_id',
        'quotable_type'
    ];

    public function quotable(){
        return $this->morphTo();
    }

    public function trainingSession(){
        return $this->belongsTo(TrainingSession::class);
    }
}
