



@extends('layouts.app')

@section('content')

	<div class="main-container">
		<!-- heading -->
		<div class="container-fluid" id="top_header" >
			
					 <h2 class="text-center">All Projects</h2>
					 <div class="row">
					 	<div class="col-md-8 col-md-offset-2">
					 		<div class="input-group input-group-lg">
								  <input type="text" class="form-control" placeholder="search" aria-describedby="basic-addon2">
								  <span class="input-group-btn" id="basic-addon2"><button class="btn btn-default">
								  	<i class="fas fa-search" style="color:#228AE6"></i> projects
								  </button> </span>
							</div>
					 	</div>
					 </div>
				
				
			</div>
	       
	
		

		<div class="row">
			<div class="col-md-10 col-md-offset-1 mt-5"  style="background-color: white;">
			
				<div class="row">
					<div class="col-md-3 m-b-30">
						<div class="row ">
							<div class="col-md-11 col-md-offset-1  m-t-30  bg_grey" style=" padding: 10px;">

									<div class="form-group " >
									<label> sort by:</label>
									<select class="form-control select-lg">
										<option>date </option>
										<option>likes</option>
									</select>
								</div>
								
								
							</div>
						</div>
						<div class="row ">
							<div class="col-md-11 col-md-offset-1  bg_grey m-t-30 " style=" padding: 10px;">
								<a href="{{route('user.projects.index')}}" class="btn btn-primary btn-block btn-nobg-color">view my projects</a>
							</div>
						</div>		
						
						<div class="row">
							<div class="col-md-11 col-md-offset-1  bg_grey" >
								

								<ul class="nav nav-pills nav-stacked">
									<li role="presentation m-t-10" >
									  	<a href="{{route('projects.home', 0)}}">All projects
									  		<span class="badge pull-right">{{App\Project::all()->count()}}</span> </a>

									  </li>
									@foreach($categories as $project_category)

									  <li role="presentation m-t-10"  style="font-weight: 400" class=" @if($active_category)
											  	{{$project_category->id==$active_category->id?'active':''}}
											  	@endif">
									  	<a href="{{route('projects.home', $project_category->id)}}" >
									  	{{$project_category->name}} <span class="badge pull-right">{{$project_category->projects->count()}}</span></a>

									  </li>
								
									 @endforeach
								</ul>
						
							</div>
						</div>
					</div>

					<div class="col-md-9 " style="padding: 20px" >
						<div class="row">
							<div class="col-md-8 m-t-30">
								<h3> displaying {{$projects->count()}} results  {{
									isset($active_category->name)?'for '.$active_category->name:''}}</h3>
							</div>
							<div class="col-md-3 col-md-offset-1  m-t-30">
							
								<a href="{{route('user.projects.create')}}" class="btn btn-primary btn-block  pull-right"> upload new project</a>
								
							</div>
						</div>

						<div class="row ">
							<div class="col-md-12 m-t-30">
								@foreach($projects as $project)
								<div class="row m-t-30" id="project_box">
								  <div class="col-md-8 col-md-offset-2  bg_grey" style=" padding: 0px 20px 15px 20px;" >
									
									    

									    	<div class="row m-t-10">
									    		<div class="col-md-12" >
									    			<a href="" id="project_name" 
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
											    			<a href="{{route('user.projects.edit', $project->id)}}"  class="btn btn-primary btn-sm btn-nobg-color"
		    											>edit</a>
											    		</div>
											    	</div>
										    	@endif
									    	@endforeach
									    
									 
								  </div>
								</div>
								@endforeach
							
									{{--{{ substr(strip_tags(),0,60) }} <span style="color: blue"> {{ strlen(strip_tags($project->name ))>60?'....':'' }}--}}
							

										
							</div>
						</div>

						
					</div>
				</div>
				{{--{{ substr(strip_tags($project->filepath),0,38) }} <span style="color: blue"> {{ strlen(strip_tags($project->filepath))>38?'....':'' }} </span>--}}
				
				<center>
				{{ $projects->links()}}
				</center>
				</div>
			</div>
		</div>

	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){

		});
	</script>
@endsection


