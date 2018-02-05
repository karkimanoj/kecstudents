<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadDetail2 extends Model
{
	public $timestamps = false;
    protected $table='download_details2';
    protected $fillable = ['faculty_id', 'semester'];

      public function download(){
    	return $this->belongsTo('App\Download');
    }

    public function faculty(){
    	return $this->belongsTo('App\Faculty');
    }

}
