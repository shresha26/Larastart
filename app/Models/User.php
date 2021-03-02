<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    CONST SUPER_ADMIN = 1;
    CONST ADMIN = 2;
    CONST NORMAL_USER = 3;
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'type' // admin, passenger, driver
        // TODO only user type admin can access webpage. passenger and driver can only access mobile app
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function userType(){
        return $this->belongsTo(Usertype::class,'type');
    }
}
