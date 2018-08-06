<?php

namespace App\Observers;

use Illuminate\Support\Collection;
use App\Project;
use App\User;
use Notification;
use Auth;
use App\Notifications\ProjectNotification;

class ProjectObserver
{
    
    public function created(Project $project)
    {   
        $type = 'created';
        $users = new Collection;
       foreach ($project->project_members()->where('roll_no', '!=' , $project->user->roll_no)->get() as $member)
        {   
            if($user = User::where('roll_no', $member->roll_no)->first())
            $users->push($user);
        }
        if($users)
            Notification::send($users, new ProjectNotification($project, $type));
    }

    public function updated(Project $project)
    {
        $type = 'updated';
        $users = new Collection;
       foreach ($project->project_members()->where('roll_no', '!=' , Auth::user()->roll_no)->get() as $member)
        {   
            if($user = User::where('roll_no', $member->roll_no)->first())
            $users->push($user);
        }

        if($users)
            Notification::send($users, new ProjectNotification($project, $type));
        
    }
    
    public function deleted(Project $project)
    {
        $type = 'deleted';

       $users = new Collection;
       foreach ($project->project_members()->where('roll_no', '!=' , Auth::user()->roll_no)->get() as $member)
        {   
            if($user = User::where('roll_no', $member->roll_no)->first())
            $users->push($user);
        }
      

        if($users)
            Notification::send($users, new ProjectNotification($project, $type));
    }
}