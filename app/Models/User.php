<?php

namespace App\Models;

use Andegna\DateTimeFactory;
use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use BlameableTrait;
    use HasRoles;



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'father_name',
        'grand_father_name',
        'email',
        'password',
        'dob',
        'gender',
        'trainining_center_id'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    public static function administratorUsers()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name','!=', 'volunteer');
        });
    }
    public static function getUserWithoutRole(Role $role)
    {
        return User::whereHas('roles', function ($query) use($role) {
            $query->where('name','!=', $role->name);
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function name()
    {
        return $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name;
    }
    public function getSessionAttribute()
    {
        return request()->route('training_session');
    }
    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name;
    }

    public function getGender()
    {
        return $this->gender == 'M' ? 'Male' : 'Female';
    }
    /**
     * Get the trainner associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function trainner(): HasOne
    {
        return $this->hasOne(TrainingMaster::class);
    }

    /**
     * Get the volunteer associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function volunteer(): HasOne
    {
        return $this->hasOne(Volunteer::class, 'user_id', 'id');
    }

    // public function payroll()
    //      {
    // return $this->hasMany('App\Payroll');
    //      }
    public function payrollsheets(){

    return $this->hasMany(PayrollSheet::class);
    }

    public function paymentReport(){
        return $this->hasMany(PaymentReport::class);
    }

    public function payrolls(){
        return $this->hasMany(Payroll::class);
    }

    public function distances(){
        return $this->hasMany(Distance::class);
    }

    // public function payrollsheet()
    //      {
    // return $this->hasMany('App\PayrollSheet');
    //      }

    public function getProfilePhoto()
    {
        return $this->photo ?? asset('user.png');
    }

    public function dobET()
    {
        return DateTimeFactory::fromDateTime(new DateTime($this->dob))->format('d/m/Y');
    }
    public function getRole()
    {
        return count($this->roles) > 0 ? $this->roles[0] : null;
    }

    public function isCordinator()
    {
        return $this->isRegionalCordinator() != null || $this->isZoneCordinator() != null;
    }

    public function isRegionalCordinator()
    {
        return $this->getCordinatingRegion() != null ? true : false;
    }

    public function isZoneCordinator()
    {
        return $this->getCordinatingZone() != null ? true : false;
    }

    public function getCordinatingRegion()
    {
        if ($this->isZoneCordinator()) {
            return $this->getCordinatingZone()->region;
        }
        return UserRegion::where('user_id', $this->id)->where('levelable_type', Region::class)->first()?->levelable;
    }
    public function getCordinatingZone()
    {
        return UserRegion::where('user_id', $this->id)->where('levelable_type', Zone::class)->first()?->levelable;
    }

    public function trainingCheckerOf()
    {
        return $this->belongsTo(TraininingCenter::class,'trainining_center_id', 'id');
    }

    public function attendances(){
        return $this->hasMany(UserAttendance::class);
    }
    
}
