
<body>
<div class="row m-t-30 " id="project_box">
  <div class="col-md-8 offset-md-2  bg_grey border_purple" style=" padding: 0px 20px 15px 20px;" >

	    	<div class="row m-t-10">
	    		<div class="col-md-12" >
	    			<a href="{{route('user.projects.show', $project->id)}}" id="project_name" 
				>{{$project->name}}</a>
	    		</div>
	    	</div> 
	    	<div class="row m-t-10">
	    		<div class="col-md-6" >
	    			<i class="fas fa-user"></i> 
	    			{{ $project->user->name }}
	    		</div>
	    		<div class="col-md-6" >
	    			<i class="fab fa-cuttlefish"></i>
	    			{{$project->subject->name}}
	    		</div>
	    	</div>
	    	<div class="row m-t-10">
	    		<div class="col-md-6" >
	    			<i class="fas fa-tags"></i>
	    			@foreach($project->tags as $tag)
	    			<span class="label label-success">
	    				{{$tag->name}}</span>
	    				
	    			@endforeach
	    		</div>
	    		<div class="col-md-6" >
	    			<i class="far fa-clock"></i>
	    			{{ $project->created_at->toFormattedDateString() }}
	    		</div>
	    	</div>
	    	@foreach($project->project_members as $member)
		    	@if($member->roll_no==Auth::user()->roll_no)
			    	<div class="row m-t-10">
			    		<div class="col-md-6 " >
			    			<a href="{{route('user.projects.show', $project->id)}}" class="btn btn-primary btn-sm btn-nobg-color" 
						>view</a>
			    		</div>
			    		<div class="col-md-6 " >
			    			<a href="{{route('user.projects.edit', $project->id)}}"  class="btn btn-outline-primary btn-sm "
						>edit</a>
			    		</div>
			    	</div>
		    	@endif
	    	@endforeach
	    
	 
  </div>
</div>







<ul class="pagination">
	<li class="page-item disabled"><span class="page-link">«</span></li> 

	<li class="page-item"><span class="page-link">1</span></li> 

	<li class="page-item"><a href="http://localhost:8000/projects/0/index?page=2" class="page-link">2</a></li> 

	<li class="page-item"><a href="http://localhost:8000/projects/0/index?page=3" class="page-link">3</a></li> 

	<li class="page-item active"><a href="http://localhost:8000/projects/0/index?page=2" rel="next" class="page-link">»</a></li>
	
</ul>
$projects = DB::table('projects')->join('users', 'users.id','=','projects.uploader_id')
                             ->join('subjects', 'subjects.id', '=', 'projectd.subject_id')
                             ->select('projects.*', 'users.name', 'subjects.name')
                             ->latest('created_at')->paginate(2);