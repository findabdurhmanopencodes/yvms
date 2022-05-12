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
        'qoutaInpercent',
        'status'
    ];

    public function zones(){
        return $this->hasMany(Zone::class);
    }

    public function quotas(){
        return $this->morphMany(Qouta::class, 'quotable');
    }


    public function level(){
        return $this->morphOne(UserRegion::class, 'levelable');
    }

}
