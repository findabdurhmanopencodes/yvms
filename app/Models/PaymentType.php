<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentType extends Model
{
    use HasFactory;

protected $fillable = [ 'name','amount'];


// public function volunteers(){

//     return $this->hasMany(Volunteer::class);
//     }
}
