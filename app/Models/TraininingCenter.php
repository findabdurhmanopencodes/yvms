<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;

class TraininingCenter extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    public static $status = [
        0 => 'Disactive',
        1 => 'Active',
    ];

    protected $fillable = ['name', 'code', 'logo', 'zone_id','scale','status'];

    protected $append = ['region'];
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function getRegionAttribute()
    {
        return $this->zone?->region;
    }
    /**
     * Get the photo that owns the TraininingCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo(): BelongsTo
    {
        return $this->belongsTo(File::class, 'logo', 'id');
    }


    public function getLogo()
    {
        return $this->photo?->file_path ?? asset('ju_logo.png');
    }

    public function capacities()
    {
        return $this->hasMany(TrainingCenterCapacity::class, 'trainining_center_id', 'id');
    }

    public function distances(){
        return $this->hasMany(Distance::class);
    }

    public function PayrollSheet(){
        return $this->hasMany(PayrollSheet::class);
    }


    public function PaymentReport(){
        return $this->hasMany(PaymentReport::class);
    }


    public function checkers()
    {
        return $this->hasMany(User::class);
    }
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_trainining', 'trainining_center_id', 'resource_id')->withPivot('current_balance', 'initial_balance');
    }

    /**
     * Get all of the rooms for the TraininingCenter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(CindicationRoom::class);
    }
}
