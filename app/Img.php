<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{	
	protected $fillable=['filepath'];
	
	public function __construct() 
    {
	    parent::__construct();
	    $this->table = session('tenant').'_images';
    }
	
	
    public function imagable(){
    	return $this->morphTo();
    }
}
