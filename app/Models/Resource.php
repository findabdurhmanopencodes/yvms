<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $fillable=['name'];

    public function traininingCenters()
    {
        return $this->belongsToMany(TraininingCenter::class,'resource_trainining')->withPivot('current_balance','initial_balance'   );
    }
}
