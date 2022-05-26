<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionIntake extends Model
{
    use HasFactory;
    protected $table = "region_intakes";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'training_session_id',
        'region_id',
        'intake',
    ];

    public function region(){
        return $this->belongsTo(Region::class);
    }
    
}
