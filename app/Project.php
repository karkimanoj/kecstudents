<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{


	public function user(){
		return $this->belongsTo('App\User','uploader_id');
	}

    public function tags(){
    	return $this->morphToMany('App\Tag','taggable');
    }

    public function project_members(){
    	return $this->hasMany('App\ProjectMember');
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }

}
