<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event1Member extends Model
{
	use SoftDeletes;

	public function __construct()
	{
		 parent::__construct();
		$this->table = Session('tenant').'_event1_members';
	}

   /*
      //elequont dont support composite primary key, this method solves this problem
       protected function setKeysForSaveQuery(Builder $query)
       {
           $query
               ->where('event1_id', '=', $this->getAttribute('event1_id'))
               ->where('user_id', '=', $this->getAttribute('user_id'));
           return $query;
       }*/

   	public function event1()
   	{
   		return $this->belongsTo('App\Event1', 'event1_id');
   	}

   	public function user()
   	{
   		return $this->belongsTo('App\User');
   	}
}
