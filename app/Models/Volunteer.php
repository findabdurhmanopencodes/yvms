<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Volunteer extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
     * Get the user that owns the Volunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }



    public function picture()
    {
        return File::find($this->photo);
    }
    public function getMinistryFileSize()
    {
        return Storage::size(File::find($this->ministry_document)->file_path);
    }
    public function getBsc()
    {
        return File::find($this->bsc_document);
    }
    public function getMsc()
    {
        return File::find($this->msc_document);
    }
    public function getPhd()
    {
        return File::find($this->phd_document);
    }
    public function getEthical()
    {
        return File::find($this->ethical_license);
    }
    public function getPregnant()
    {
        return File::find($this->non_pregnant_validation_document);
    }

    public function woreda()
    {
        return $this->belongsTo(Woreda::class);
    }
    public function fieldOfStudy()
    {
        return $this->belongsTo(FeildOfStudy::class);
    }
    public function educationalLevel()
    {
        return EducationalLevel::$educationalLevel;
    }
    public function status()
    {
        return $this->hasOne(Status::class);
    }

    public function approvedApplicants(){
        return $this->hasMany(ApprovedApplicant::class);
    }

}
