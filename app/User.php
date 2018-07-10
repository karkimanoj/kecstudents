<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','roll_no', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function downloads(){
        return $this->hasMany('App\Download','uploader_id');
    }

    public function projects(){
        return $this->hasMany('App\Project','uploader_id');
    }

    public function event1s()
    {
        return $this->hasMany('App\Event1');
    }

    public function event1_members()
    {
        return $this->hasMany('App\Event1Member');
    }

}
