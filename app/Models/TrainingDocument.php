<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class TrainingDocument extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    /**
     * Get the file that owns the TrainingDocument
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }
}
