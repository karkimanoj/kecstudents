
@extends('layouts.app')

@section('content')
	<div class="main-container bg_grey">
	    <div class="container-fluid" id="top_header" >
          	<h2 class="text-center">view project</h2>
        </div>

        <!-- Modal -->
			  <div class="modal fade " id="myModal" role="dialog">
			    <div class="modal-dialog modal-sm">
			      <!-- Modal content-->
			      <div class="modal-content">

			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Confirm deletion</h4>
			        </div>

			        <div class="modal-body">
			          <p>Are you sure?</p>
			        </div>

			        <div class="modal-footer">
			        	<div class="row">
			        		<div class="col-md-6">
			        			<form method="POST" action="{{ route('projects.destroy', $project->id) }}" >
					        		{{method_field("DELETE")}}
					        		{{csrf_field()}}
					        		<input type="submit" class="btn btn-danger float-right" name="delete" value="yes">
								</form>		
			        		</div>
			        		<div class="col-md-6">
			        			<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
			        		</div>
			        	</div>	
			        </div>
			      </div>
			      
			    </div>
			  </div> <!-- end of modal -->	

		<div class="container">
			<div class="row mb-4">
				<div class="col-md-9 p-4" style="background-color: white">
					<div class="row mt-4">
						<div class="col">
							<h4 >{{$project->name}}</h4> 
							<div class="row" style="font-size: 0.9rem">
								<div class="col-md-6">
									<i class="fas fa-user" ></i> <span class="text-primary">{{$project->user->name}} <i>[{{$project->user->roll_no}}]</i></span>
								</div>
								<div class="col-md-6">
									<i class="far fa-clock" style="color:#228AE6;"></i> <span class="text-muted">{{$project->created_at->toFormattedDateString()}}</span>

								</div>
							</div>
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">

							<div class="row mt-4" >
								<div class="col">
									<i class="fas fa-comments fa-3x"></i> <span style="font-size: 3rem;"> 3</span>
								</div>
							</div>	

							<div class="row mt-4">
								<div class="col">
									<h5><i class="fas fa-users" ></i> Members</h5>
									<ul class="list-group text-muted list-group-flush" style="font-weight: 600">
									  	@foreach($project->project_members as $members)			
									 		<li style="font-size: 0.8rem" class="list-group-item">{{$members->name}} [{{$members->roll_no}}]</li>
									 	@endforeach
									</ul>
								</div>
							</div>
							<div class="row mt-4">
								<div class="col">
									<h5><i class="fas fa-tags" ></i> Tags</h5>
										<ul class="list-inline">
										@foreach($project->tags as $tag)
										  <li class="list-inline-item">
										  	<span class="badge badge-success">{{$tag->name}}
										  	</span>
										  </li>
										@endforeach
									</ul>
								</div>
							</div>		
							
						</div>

						<div class="col-md-8 mt-3">

							<div class="row">
								<div class="col">
									<i class="fab fa-cuttlefish" ></i>
									  {{$project->subject->name}}
								</div>
							</div>

							<div class="row">
								<div class="col mt-3 text-center" style="color: rgba(0,0,0,.84); ">
									<p>
										{!!$project->abstract!!}
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mt-3">
									<a href="{{ asset($project->filepath) }}" class="btn btn-info ">downoad report</a>
								</div>
								<div class="col-md-6 mt-3">
									<a href="{{ asset($project->url_link) }}" class="btn btn-info "><i class="fab fa-github" > </i> github link</a>
								</div>
							</div>
							<div class="row">								
									<div class="col-md-12 mt-5">
										<h6 style="font-weight: 800">Screenshots/photos:</h6>
										@foreach($project->imgs as $image)
										<img src="{{asset($image->filepath)}}"  width="100%" class="mt-4">
										@endforeach
									</div>
								
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-3">
					@if(App\ProjectMember::where('project_id', $project->id)->where('roll_no', Auth::user()->roll_no)->first())
						<div class="card  card_shadow w-100 borderless mt-4" id="user_widget">
		                    <div class="card-header  " style="background-color: #F39C12">
			                     <div id="card_img">
			                   
			                         <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "?s=50&d=retro" }}" class=" card-img img-circle bg-primary card_shadow">
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
			                      <span class="badge ">{{Auth::user()->projects->count()}}</span><br>
			                      <a class="nav-link active" href="{{route('user.projects.index')}}"><h7>Projects<h7> </a>
			                    </li>
			                    <li class="nav-item">
			                       <span class=" badge badge-light">31</span><br>
			                      <a class="nav-link" href="#">Events</a>
			                    </li>
			                    <li class="nav-item">
			                      <span class=" badge badge-light">{{Auth::user()->downloads->count()}}</span><br>
			                      <a class="nav-link" href="#">Downloads </a>
			                    </li>
			                    <li class="nav-item">
			                      <span class="badge badge-light">31</span><br>
			                      <a class="nav-link" href="#">posts </a>
			                    </li>
			                  </ul>		                    
			                      
			                </div>
		                
			                <div class="card-footer bg-white borderless">
			                  <div class="row">
			                    <div class="col-md-6">
			                      <a href="{{route('user.projects.edit', $project->id)}}" class="btn btn-primary btn-sm btn-block">edit </a>
			                    </div>
			                    <div class="col-md-6">
			                    	<a class="btn btn-outline-danger btn-sm btn-block" data-toggle="modal" data-target="#myModal" href="#">delete </a>
			                      
			                    </div>

			                  </div>
			                </div>

		              	</div>
	              	@endif

	              	<div class="row">
	              		<div class="col-md-11 offset-md-1 mt-4 pl-3 pt-3  bg-white" id="pop_project_div" style="font-size: 0.8rem">
	              			<h5>popular projects:</h5>
	              			<ul  class="nav nav-tabs list-group mt-3">
							  <li class="nav-item list-group-item">
							    <a class="nav-link " href="#">
							    kecstudents portal<br>
							    <i class="fab fa-cuttlefish" ></i>c programming
								</a>
							  </li>
							  <li class="nav-item list-group-item">
							    <a class="nav-link" href="#">hamroshoe store
							    <br>
							    <i class="fab fa-cuttlefish" ></i>c programming</a>
							  </li>
							  <li class="nav-item list-group-item">
							    <a class="nav-link" href="#">virtual kec
							    <br>
							    <i class="fab fa-cuttlefish" ></i>minor project(bct)</a>
							  </li>
							  <li class="nav-item list-group-item">
							    <a class="nav-link" href="#">kathmandu valley soil analysis
							    <br>
							    <i class="fab fa-cuttlefish" ></i>c programming</a>
							  </li>
							   <li class="nav-item list-group-item">
							    <a class="nav-link" href="#">kecstudents portal
							    <br>
							    <i class="fab fa-cuttlefish" ></i>minor project(bct)</a>
							  </li>
							   <li class="nav-item list-group-item">
							    <a class="nav-link " href="#">kathmandu valley soil analysisl
							    <br>
							    <i class="fab fa-cuttlefish" ></i>soil mechanics</a>
							  </li>

							</ul>
	              		</div>
	              	</div>

				</div>
			</div>
		</div>  


			
	</div>
@endsection


