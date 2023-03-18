<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class TrainingCenterBasedPermission extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function traininingCenter(){
        return $this->belongsTo(TraininingCenter::class);
    }

    /**
     * Get the syndicationRoom that owns the TrainingCenterBasedPermission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syndicationRoom(): BelongsTo
    {
        return $this->belongsTo(CindicationRoom::class, 'cindication_room_id', 'id');
    }
}
