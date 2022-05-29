<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoredaIntake extends Model
{
    use HasFactory;

    protected $table = "woreda_intakes";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'training_session_id',
        'woreda_id',
        'intake',
    ];

    public function woreda()
    {
        return $this->belongsTo(Woreda::class);
    }

    public function getRegionAttribute()
    {
        return $this->woreda->region;
    }
}
