
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
					@foreach($project->project_members()->withTrashed()->get() as $member)

						@if( $member->roll_no == Auth::user()->roll_no && $member->trashed()) 
						
							<div class="row mt-1">
								<div class="col">
									<div class="alert alert-primary" role="alert">
									  <h5>Are you the member of this project?</h5> 
									  
									
								<form action="{{route('user.projects.confirmMember', $project->id)}}" method="POST" id="confirm_member_form">
								{{csrf_field()}}  
									<div class="btn-group-toggle" data-toggle="buttons">
									  <label class="btn btn-primary" >
									    <input type="radio" name="confirm"   value="yes"  id="yes_radio"> yes
									  </label>
									  <label class="btn btn-primary" >
									    <input type="radio" name="confirm"   value="no" id="no_radio"> No
									  </label>
									</div>

								</form>
									</div>
								</div>
							</div>
							@break
						@endif
					@endforeach
						
					<div class="row mt-2">
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
									<i class="fas fa-comments fa-3x"></i> <span style="font-size: 3rem;"> <a href="{{Request::url().'#disqus_thread'}}">0</a></span>
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
								
								@if($project->url_link)
									<div class="col-md-6 mt-3">
										<a href="{{ asset($project->url_link) }}" class="btn btn-info "><i class="fab fa-github" > </i> github link</a>
									</div>
								@endif

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
					<div class="row">
						<div class="col-md-12">
							<hr>
							<center><h1>Comments</h1></center>

							<div id="disqus_thread">
								<script>

								/**
								*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
								*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
								
								var disqus_config = function () {
								this.page.url = '{{Request::url()}}';  // Replace PAGE_URL with your page's canonical URL variable
								this.page.identifier = {{$project->id}}; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
								this.callbacks.onNewComment = [function(comment) {
								comment_notify(comment.id, comment.text);
					          
					        	}];
								};
								
								(function() { // DON'T EDIT BELOW THIS LINE
								var d = document, s = d.createElement('script');
								s.src = 'https://studentportal-1.disqus.com/embed.js';
								s.setAttribute('data-timestamp', +new Date());
								(d.head || d.body).appendChild(s);
								})();
								
								</script>
								
								                            
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
	              		<div class="col-md-11 offset-md-1 mt-4  bg-white"  style="font-size: 0.8rem">
	              			<h5 class="mt-2">Popular Projects:</h5>
	              			<ul  class="nav nav-tabs list-group mt-3 ">
	              				@foreach($popular_projects as $pop_project)
							  <li class="nav-item list-group-item">
							    <a class="nav-link " href="{{route('user.projects.show',  $pop_project->id)}}">
							   	{{($loop->index + 1).'. '.$pop_project->name }}
								</a>
							  </li>
							  @endforeach
							</ul>
	              		</div>
	              	</div>

				</div>
			</div>
		</div>  


			
	</div>
@endsection

@section('scripts')
<script type="text/javascript">
	function comment_notify(comment_id, comment_text)
		{
			//comment_notify1(comment_id, comment_text);
			$.ajax({
				type :'GET',
		        url : '{{route('user.comments.notifyComment')}}',
		       
		        data:{	'token' : '{{csrf_token()}}',
		        		'primary_id': '{{$project->id}}',
		        		'comment_id' : comment_id,
		               'model' : 'Project'
					 },
				success : function(data){
					console.log(data)
				},
				error : function(err){
					console.log(err);
				}	 
			});
		}
		
	$(document).ready(function(){

		$('#yes_radio, #no_radio').on('change', function(){
			//alert($(this).val())
			$('#confirm_member_form').submit();
		});
	});	
</script>
@endsection
