<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	public function __construct() 
    {
	    parent::__construct();
	    $this->table = session('tenant').'_posts';
    }
    
    public function user(){
		return $this->belongsTo('App\User', 'author_id');
	}

	
	public function imgs(){
        return $this->morphMany('App\Img', 'imagable');
    }


     public function tags(){
    	return $this->morphToMany('App\Tag', 'taggable', session('tenant').'_taggables');
    }
}
