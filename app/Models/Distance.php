<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Auditor;

class Distance extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;



    protected $fillable = [
        'zone_id','trainining_center_id','km','user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function zone(): BelongsTo
    {

        return $this->belongsTo(Zone::class);
    }

    public function traininingCenter(): BelongsTo
    {
        return $this->belongsTo(TraininingCenter::class);
    }
}
