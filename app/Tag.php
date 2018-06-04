<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	public function __construct() 
    {
	    parent::__construct();
	    $this->table = session('tenant').'_tags';
    }

    public function projects(){
    	return $this->morphedByMany('App\Project', 'taggable', session('tenant').'_taggables');
    }
}
