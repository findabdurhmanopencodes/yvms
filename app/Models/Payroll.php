<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [ 'name', 'training_session_id', 'user_id','created_at','updated_at' ];

// public function getUser()
// {
//     return $this->hasOne(User::class, 'id', 'id');
// }


public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function trainingSession(): BelongsTo
{
    return $this->belongsTo(TrainingSession::class);
}

public function payrollsheet(){
    return $this->hasMany(PayrollSheet::class);
  }
}
