<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSheet extends Model
{
use HasFactory;

protected $fillable = [ 'fullName', 'trainining_center', 'phone','account' ,'zone_id','user_id','created_at']; 

    public function user()
{
    return $this->belongsTo('App\User');
}

public function trainingCenter()
{
    return $this->belongsTo('App\TrainingCenter');
}

public function zones()
{
    return $this->belongsTo('App\Zone');
}
public function payroll()
{
    return $this->belongsTo('App\Payroll');
}

}
