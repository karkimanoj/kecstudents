<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Event1 extends Model
{
	use SoftDeletes;

	protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_at',
        'end_at'
       
    ];

	public function __construct()
	{
		parent::__construct();
		$this->table = Session('tenant').'_event1s';
	}

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function event1_members()
    {
    	return $this->hasMany('App\Event1Member', 'event1_id');

    }

    
    //accessors for converting start_time and end_time values to different time format
    public function getStartTimeAttribute()
    {
        return $this->start_at->format('H:i');
        
    }
    public function getEndTimeAttribute()
    {
        return $this->end_at->format('H:i');
        
       
    }

    public function getStartDateAttribute()
    {
        return $this->start_at->toDateString();
        
    }

     public function getEndDateAttribute()
    {
        return $this->end_at->toDateString();
        
    }
}
