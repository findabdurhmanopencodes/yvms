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
use RichanFongdasen\EloquentBlameable\BlameableTrait;
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
        'gender'
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

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name;
    }

    public function getGender()
    {
        return $this->gender == 'M' ? 'Male' : 'Female';
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
        return count($this->roles)>0?$this->roles[0]:null;
    }
}
