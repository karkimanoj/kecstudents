<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    public function user(){
        return $this->belongsTo('App\User','uploader_id');
    }

    public function download_category(){
        return $this->belongsTo('App\DownloadCategory','category_id');
    }

    public function download_detail1(){
    	return $this->hasOne('App\DownloadDetail1');
    }

    public function download_detail2(){
    	return $this->hasOne('App\DownloadDetail2');
    }

}
