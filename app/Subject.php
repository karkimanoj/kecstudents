<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $table='subjects';

    public function faculties(){
    	return $this->belongsToMany('App\Faculty')->withPivot('semester');
    }
}
