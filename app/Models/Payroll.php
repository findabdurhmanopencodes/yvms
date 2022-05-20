<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'training_session', 'user'.'created_at' ];

public function payroll()
{
    return $this->hasOne(Payroll::class, 'approved_applicant_id', 'id');
}
}
