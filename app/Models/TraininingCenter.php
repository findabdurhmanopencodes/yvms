<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraininingCenter extends Model
{
    use HasFactory;
    protected $fillable=['name','code','logo','zone_id'];

    public function zones()
    {
        return $this->belongsTo(Zone::class);
    }
}
