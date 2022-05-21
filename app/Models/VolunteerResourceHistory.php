<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerResourceHistory extends Model
{
    use HasFactory;
    protected $fillable=['volunteer_id','training_session_id','resource_id','training_center_id','amount'];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
