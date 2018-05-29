<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $table='subjects';

    public function faculties(){
    	return $this->belongsToMany('App\Faculty')->withPivot('semester');
    }

    public function downloads(){
    	return $this->hasMany('App\Download');
    }

    public function projects(){
    	return $this->hasMany('App\Project');
    }

}
