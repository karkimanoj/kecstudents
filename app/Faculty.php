<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Faculty extends Model
{
	protected $table='faculties';

	public function __construct() 
    {
	    parent::__construct();
	    $this->table = session('tenant').'_faculties';
    }

   	public function subjects(){
   		return $this->belongsToMany('App\Subject', session('tenant').'_faculty_'.session('tenant').'_subject')->withPivot('semester');
   	}

   	public function downloads(){
    	return $this->hasMany('App\Download');
    }
}
