<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Request;
class Post extends Model
{   //public $table = 'kec_posts';
  	public function __construct() 
    {
	    parent::__construct();
        $this->table = session('tenant').'_posts';
    }
    
    public function user(){
		return $this->belongsTo('App\User', 'author_id');
	}

	
	public function imgs(){
        return $this->morphMany('App\Img', 'imagable', 'imagable_type', 'imagable_id');
    }


     public function tags(){
    	return $this->morphToMany('App\Tag', 'taggable', session('tenant').'_taggables');
    }
}
