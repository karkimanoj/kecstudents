<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMember extends Model
{	
    use SoftDeletes;

	public $timestamps=false;
   // protected $table='project_members';
    protected $fillable=['roll_no', 'name'];

    public function __construct() 
    {
    parent::__construct();
    $this->table = session('tenant').'_project_members';
    }

    public function project(){
    	return $this->belongsTo('App\Project');
    }
}
