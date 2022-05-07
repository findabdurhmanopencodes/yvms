<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Woreda extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'zone_id',
        'qoutaInpercent'
    ];

    public function zone(){
        return $this->belongsTo(Zone::class);
    }

    public function quotas(){
        return $this->morphMany(Qouta::class, 'quotable');
    }
}
