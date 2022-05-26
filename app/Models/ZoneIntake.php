<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneIntake extends Model
{
    use HasFactory;
    protected $table = "zone_intakes";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'training_session_id',
        'zone_id',
        'intake',
    ];

    public function zone(){
        return $this->belongsTo(Zone::class);
    }
}
