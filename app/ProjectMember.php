<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{	
	public $timestamps=false;
    protected $table='project_members';
    protected $fillable=['roll_no', 'name'];

    public function project(){
    	return $this->belongsTo('App\Project');
    }
}
