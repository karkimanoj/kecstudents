<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
	protected $fillable=['filepath'];

    public function __construct() 
    {
        parent::__construct();
        $this->table = session('tenant').'_subjects';
    }

    public function faculties(){
    	return $this->belongsToMany('App\Faculty',  session('tenant').'_faculty_'.session('tenant').'_subject')->withPivot('semester');
    }

    public function downloads(){
    	return $this->hasMany('App\Download');
    }

    public function projects(){
    	return $this->hasMany('App\Project');
    }

}
