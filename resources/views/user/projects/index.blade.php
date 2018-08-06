



@extends('layouts.app')

@section('content')

<div class="main-container">
		<!-- heading -->
		<div class="row ml-0 mr-0">
			<div class="col-md-12" id="top_header" >
				
				 <h2 class="text-center">All Projects</h2>
				 <div class="row">
				 	<div class="col-md-8 offset-md-2">
				 		<div class="input-group input-group-lg">
							  <input type="text" class="form-control" placeholder="search" aria-label="Large" aria-describedby="basic-addon2">
							  <div class="input-group-prepend"> 
							  	<button class="btn btn-default" type="button" id="basic-addon2">
							  	<i class="fas fa-search" style="color:#228AE6"></i> projects
							  </button> 
							</div>
						</div>								

				 	</div>
				 </div>
					
			</div>		
		</div>
	       
	
		
	<div class="container">		
		<div class="row">
			<div class="col-md-9 "  style="background-color: white;">
			
				<div class="row mt-5 mb-5">

					<div class="col-md-12 " style="padding: 20px" >
						<div class="row">
							<div class="col-md-8 text-center">
								<h4 class="text-muted"> displaying {{$projects->count()}} results  {{
									isset($active_category->name)?'for '.$active_category->name:''}}</h4>
							</div>
							
						</div>

						<div class="row ">
							<div class="col-md-12 mt-3">
								@foreach($projects as $project)
								<div class="row m-t-30" id="project_box">
								  <div class="col-md-8 offset-md-2  bg_grey" style=" padding: 0px 20px 15px 20px;" >
									
									    

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
								@endforeach
							
							</div>
						</div><!-- end of row -->

						
					</div>

				

					

				</div>
				
				
				
			</div>
			<div class="col-md-3 mt-3 mb-3">
				  <div class="card  card_shadow w-100 borderless" id="user_widget">
				          	<div class="card-header  " style="background-color: #F39C12">
				          		<div id="card_img">
				          			<img class="card-img img-circle bg-primary" src="/images/test-image.jpg" alt="Card image cap">
				          		</div>
				          		<div class="card_user_detail">
				          			 <span style="font-size: 1.2em">{{Auth::user()->name}}</span><br>
				              		 <span >{{Auth::user()->roles->first()->name}}</span><br>
				              		 <span >{{Auth::user()->roll_no}}</span><br>
				          		</div>
							     
							 </div>							
							  <div class="card-body ">
							   
							    	<ul class="nav flex-column text-center text-muted">
				                      <li class="nav-item">
				                        <span class="badge badge-light">{{Auth::user()->projects->count()}}</span><br>
				                        <a class="nav-link" href="{{route('user.projects.index')}}">Projects </a>
				                      </li>
				                      <li class="nav-item">
				                         <span class=" badge badge-light">{{Auth::user()->event1s()->count()}}</span><br>
				                        <a class="nav-link" href="{{route('user.events.index')}}">Events</a>
				                      </li>
				                      <li class="nav-item">
				                        <span class=" badge badge-light">{{Auth::user()->downloads->count()}}</span><br>
				                        <a class="nav-link" href="{{route('user.downloads.index')}}">Downloads </a>
				                      </li>                     
				                      <li class="nav-item">
				                        <span class="badge ">{{Auth::user()->posts->count()}}</span><br>
				                        <a class="nav-link active" href="{{route('user.posts.index')}}"><h7>posts<h7> </a>
				                      </li>
				                    </ul> 
							    	
				          		
							  </div>
							  <!--
							  <div class="card-footer bg-white borderless">
							  	<div class="user-widget-btn text-center">
							  		<button class="btn btn-primary btn-sm btn-block">save</button>
							  	</div>
							  	<div class="user-widget-btn text-center">
							  		<button class="btn btn-outline-primary btn-sm btn-block">reset</button>
							  	</div>
							  </div>
								-->
							</div>
					<div class="card w-100 mt-3 borderless" >
					  <div class="card-body">					 					    
						  <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">upload new project</a>
			              <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">upload new note</a>
			              <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">create new event</a>
			              <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">create new post</a>
					  </div>
					</div>
			</div>
		</div>
	</div>
 </div>

	
@endsection



