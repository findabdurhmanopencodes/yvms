<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class BarQRVolunteer extends Model implements Auditable
{
    use HasFactory;
    protected $guarded = [];
    use \OwenIt\Auditing\Auditable;

    protected $table = "bar_q_r_volunteers";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'volunteer_id',
        'bar_code',
        'qr_code',
    ];

    /**
     * Get the user that owns the BarQRVolunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_id', 'id');
    }
}
