<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// use LdapRecord\Laravel\Auth\LdapAuthenticatable;
// use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
// use LdapRecord\Laravel\Auth\HasLdapUser;

use App\Models\Session;
use App\Models\Theme;
use App\Models\Employee;
use App\Models\PersonalData;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'passtxt',
        'avatar',
        'username',
        'theme',
        'isAdmin',
        'guid',
        'domain',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'passtxt'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isAdmin' => 'integer',
        'theme_id' => 'integer',
    ];
    // protected $with = ['employee'];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function theme()
    {
        return $this->hasOne(Theme::class);
    }

    public function personalData()
    {
        return $this->hasOne(PersonalData::class);
    }

}