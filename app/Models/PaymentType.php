<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;


protected $fillable = [ 'name','amount'];



public function PaymentReport(){
    return $this->hasMany(PaymentReport::class);
   }

// public function volunteers(){

//     return $this->hasMany(Volunteer::class);
//     }
}
