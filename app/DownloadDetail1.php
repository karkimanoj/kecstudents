<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadDetail1 extends Model
{
	public $timestamps = false;
    protected $table='download_details1';
    protected $fillable = ['subject_id'];

    public function download(){
    	return $this->belongsTo('App\Download');
    }

    public function subject(){
    	return $this->belongsTo('App\Subject');
    }
}
