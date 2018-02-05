<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadCategory extends Model
{
    public $timestamps = false;

    public function downloads(){
        return $this->hasMany('App\Download','category_id');
    }
}
