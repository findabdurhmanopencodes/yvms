<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use OwenIt\Auditing\Contracts\Auditable;

class PayrollSheet extends Model implements Auditable
{
use HasFactory;
use \OwenIt\Auditing\Auditable;


protected $fillable = [ 'fullName', 'trainining_center', 'phone','account' ,'zone_id','user_id','created_at'];



public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function traininingCenter(): BelongsTo
{
    return $this->belongsTo(TraininingCenter::class);
}

public function zone(): BelongsTo
{
    return $this->belongsTo(Zone::class);
}

public function payroll(): BelongsTo
{
    return $this->belongsTo(Payroll::class);
}

}
