<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadFile extends Model
{
	
    public $timestamps = false;
    protected $fillable=['original_filename', 'display_name', 'filepath'];

    public function download()
    {
    	return $this->belongsTo('App\Download');
    }

}
