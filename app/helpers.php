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
            
	}
}

if (! function_exists('subjects_as_facsem'))
{
   function subjects_as_facsem($faculties)
    {
        $facs=[];
        /*
        array of subjects with corresponding faculty/semester
        */
        foreach ($faculties as $faculty)
         {
            $sems=[];
          for($i=1; $i<=8; $i++)
            {
                $subs=[];
                foreach ( $faculty->subjects()->wherePivot('semester','=',$i)->get() as  $subject)
                 {
                     $subs[$subject->id]=$subject->name;
                 }
                 $sems[$i]=$subs;
            }
            $facs[$faculty->id]=$sems;

         }
         return $facs;
    }
}

if (! function_exists('remove_space_in_string'))
{
  function remove_space_in_string( $string )
  {
    $sub_parts=explode(' ', $string);
    $length=count($sub_parts);
    $sub='';
    
    for($j=0; $j<$length; $j++)
    {
        if($j==($length-1))
        $sub.=$sub_parts[$j];
      else
        $sub.=$sub_parts[$j].'_';
    }
    return $sub;
  }
}