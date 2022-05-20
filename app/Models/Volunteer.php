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
    protected $appends = ["profilePhoto"];

    public function getProfilePhotoAttribute() {
         return asset($this->picture()->file_path);
    }

    /**
     * Get the user that owns the Volunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function name()
    {
        return $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name;
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
        // dd($this->id);
        return $this->hasOne(Status::class,'volunteer_id','id');
        // return Status::where('volunteer_id',$this->id)->get();
    }

    public function approvedApplicant()
    {
        return $this->hasOne(ApprovedApplicant::class);
    }

    /**
     * Get the verifyVolunteer associated with the Volunteer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function verifyVolunteer(): HasOne
    {
        return $this->hasOne(VerifyVolunteer::class);
    }

}
