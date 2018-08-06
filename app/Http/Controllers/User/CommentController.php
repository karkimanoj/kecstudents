<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Notification;
use App\Notifications\CommentNotification;
use Auth;
use App\Event1;
use App\Project;
use App\Download;
use App\Post;
use App\User;


class CommentController extends Controller
{
	public function notifyComment(Request $request)
	{
       //$request->primary_id;
       //$request->comment_id;
		
       $users = new Collection();
       switch ($request->model) 
       {
      	case 'Event':
      		$event = Event1::find($request->primary_id);
      		foreach ($event->event1_members()->withTrashed()->where('user_id', '!=' , Auth::user()->id)->get() as $member)        
            $users->push($member->user);

            if( Auth::user()->id != $event->user->id )  
            	$users->push($event->user);
            	$title = $event->title;
      		break;
      	case 'Project':
      		$project= Project::findOrFail($request->primary_id);
      		
      		foreach ($project->project_members()->where('roll_no', '!=' ,Auth::user()->roll_no)->get() as $member)
      		{	
      			if($user = User::where('roll_no', $member->roll_no)->first())
      			$users->push($user);
      		
      		}        
            $title = $project->name;
      		break;
      	case 'Download':
      		$download = Download::findOrFail($request->primary_id);
      		$users->push($download->user);
      		$title =$download->title;
      		break;
      	case 'Post':
      		$post = Post::findOrFail($request->primary_id);
      		$users->push($post->user);
      		$title =$post->slug;
      		break;	
        }
       
         // dd($pr->name);
        if($users)
           Notification::send($users->unique(), new CommentNotification( $request->primary_id, $request->model, $title));

    }
}
