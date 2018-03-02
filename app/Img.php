<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
	protected $table='images';
	protected $fillable=['filepath'];
	
    public function imagable(){
    	return $this->morphTo();
    }
}
