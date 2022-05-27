<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Distance extends Model
{
    use HasFactory;


    protected $fillable = [
       // 'training_session_id','training_center_id','km','user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function zone(): BelongsTo
    {

        return $this->belongsTo(Zone::class);
    }

    public function trainingCenter(): BelongsTo
    {
        return $this->belongsTo(TraininingCenter::class);
    }
}
