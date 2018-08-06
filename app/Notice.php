<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    public function __construct()
	{
		parent::__construct();
		$this->table = Session('tenant').'_notices';
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function imgs()
	{
		return $this->morphMany('App\Img', 'imagable');
	}
}
