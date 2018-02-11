<?php
use App\Project;

if (! function_exists('check_members'))
{
	function check_members($subject_id, $roll_no)
	{
		
		  $project=Project::where('subject_id', $subject_id)
                    
                    ->whereIn('id', function($query) use($roll_no) {
                            $query->select('project_id')
                                  ->from('project_members')
                                  ->where('roll_no','=', $roll_no);
                                    })->first();
           if($project)
           	return $project;
        //echo 'yecxs'; else echo 'nooooooooo';       
	}
}
