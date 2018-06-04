<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    //echo session('tenant');
    //setTable('projects');
    public function __construct() 
    {
    parent::__construct();
    $this->table = session('tenant').'_projects';
    }

	public function user(){
		return $this->belongsTo('App\User','uploader_id');
	}

    public function tags(){
    	return $this->morphToMany('App\Tag', 'taggable', session('tenant').'_taggables');
    }

    public function project_members(){
    	return $this->hasMany('App\ProjectMember');
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }

    public function imgs(){
        return $this->morphMany('App\Img', 'imagable');
    }

}
