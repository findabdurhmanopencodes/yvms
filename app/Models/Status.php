<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class Status extends Model
{
    use HasFactory;
    protected $fillable=['volunteer_id','acceptance_status','rejection_reason','status'];

    public function applicants()
    {
        return $this->belongsTo(Volunteer::class);
    }


    public static $status = [
        0 => 'Pending',
        1 => 'Verified',
        2 => 'Rejected',
        3 => 'Selected',
        4 => 'Placed',
        5 => 'checked-In',
    ];

}
