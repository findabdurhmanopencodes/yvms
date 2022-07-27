<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class TrainingMasterPlacement extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    /**
     * Get the master associated with the TrainingMasterPlacement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function master(): BelongsTo
    {
        return $this->belongsTo(TrainingMaster::class, 'training_master_id', 'id');
    }

    /**
     * Get the center that owns the TrainingMasterPlacement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function center(): BelongsTo
    {
        return $this->belongsTo(TraininingCenter::class, 'trainining_center_id', 'id');
    }


    /**
     * Get the training that owns the TrainingPlacement
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }
}
