<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Resource extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['name'];

    public function traininingCenters()
    {
        return $this->belongsToMany(TraininingCenter::class,'resource_trainining','trainining_center_id','resource_id')->withPivot('current_balance','initial_balance');
    }
    public function VolunteerHistoryResource()
    {
        return $this->hasMany(VolunteerResourceHistory::class,'resource_id');
    }
}
