<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $table='subjects';

    public function faculties(){
    	return $this->belongsToMany('App\Faculty')->withPivot('semester');
    }

    public function download_detail1s(){
    	return $this->hasMany('App\DownloadDetail1');
    }

    public function projects(){
    	return $this->hasMany('App\Project');
    }

}
