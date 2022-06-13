<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use OwenIt\Auditing\Contracts\Auditable;

class Status extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['volunteer_id', 'acceptance_status', 'rejection_reason', 'status'];

    public function applicants()
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_id', 'id');
    }

    public static $status = [
        0 => 'Pending',
        1 => 'Verified',
        2 => 'Rejected',
        3 => 'Selected',
        4 => 'Placed',
        5 => 'checked-In',
        6 => 'graduated',
        7 => 'deployed'
    ];
}
