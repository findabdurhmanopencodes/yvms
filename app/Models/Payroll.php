<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'training_session_id', 'user_id','created_at','updated_at' ];

// public function getUser()
// {
//     return $this->hasOne(User::class, 'id', 'id');
// }

public function user()
{
    return $this->belongsTo('App\User');
}
public function payrollsheets(){
    return $this->hasMany(PayrollSheet::class);
  }
}
