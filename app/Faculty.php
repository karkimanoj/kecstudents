<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Faculty extends Model
{
	protected $table='faculties';

   	public function subjects(){
   		return $this->belongsToMany('App\Subject')->withPivot('semester');
   	}

   	public function download_detail2s(){
    	return $this->hasMany('App\DownloadDetail2');
    }
}
