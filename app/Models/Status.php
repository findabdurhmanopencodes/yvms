<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable=['volunteer_id','acceptance_status','rejection_reason','status'];

    public function applicant()
    {
        return $this->hasMany(Volunteer::class);
    }
    public static $status = [
        0 => 'Pending',
        1 => 'Accepted',
        2 => 'Rejected',
    ];
}
