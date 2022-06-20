<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
//use OwenIt\Auditing\Contracts\Auditable;


class PaymentReport extends Model
{
    use HasFactory;

   // use \OwenIt\Auditing\Auditable;


    protected $fillable = [ 'trainining_center_id',
                            'training_session_id',
                            'total_payee',
                            'payment_type_id',
                            'total_amount',
                            'user_id',
                            'created_at',
                            'updated_at' ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function traininingCenter(): BelongsTo
    {
        return $this->belongsTo(TraininingCenter::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }


}


