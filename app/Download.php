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
   

     public function subject(){
        return $this->belongsTo('App\Subject');
    }

    public function faculty(){
        return $this->belongsTo('App\Faculty');
    } 

    public function download_files()
    {
        return $this->hasMany('App\DownloadFile');
    }

}
