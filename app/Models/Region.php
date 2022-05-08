<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table = "regions";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'qoutaInpercent'
    ];

    public function zones(){
        return $this->hasMany(Zone::class);
    }

    public function quotas(){
        return $this->morphMany(Qouta::class, 'quotable');
    }
}
