<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IDcount extends Model
{
    use HasFactory;
    protected $table = "i_dcounts";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'volunteer_id',
        'training_session_id',
        'count',
    ];
}
