<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EducationalLevel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    public static $educationalLevel = [
        0 => 'BSc',
        1 => 'MSc',
        2 => 'PHD',
        3 => 'Diploma',
        4 => 'Level 4',
        5 => 'BA',
    ];
}
