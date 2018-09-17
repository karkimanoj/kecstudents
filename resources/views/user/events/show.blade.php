
@extends('layouts.app')

@section('content')


	<div class="main-container bg_grey">
	    <div class="container-fluid" id="top_header" >
          	<h2 class="text-center">View Event</h2>
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
			        			<form method="POST" action="{{ route('user.events.destroy', $event->id) }}" >
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
							<h4 >{{$event->title}}</h4> 
							<div class="row" style="font-size: 0.9rem">
								<div class="col-md-6">
									<i class="fas fa-user" ></i> <span class="text-primary">{{$event->user->name}} <i>[{{$event->user->roll_no}}]</i></span>
								</div>
								<div class="col-md-6">
									<i class="far fa-clock" style="color:#228AE6;"></i> <span class="text-muted">{{$event->created_at->toFormattedDateString()}}</span>

								</div>
							</div>
							<hr>
						</div>
					</div>
					<div class="row ">
						<div class="col-md-4">

							<div class="row mt-4" >
								<div class="col">
									<i class="fas fa-comments fa-3x"></i> <span style="font-size: 2rem;"> <a href="{{Request::url().'#disqus_thread'}}">0</a></span>
								</div>
							</div>
							<div class="row mt-4" >
								<div class="col">
									<i class="fas fa-eye fa-2x"></i> <span style="font-size: 2rem;"> 120</span>
								</div>
							</div>			
							
						</div>

						<div class="col-md-8 mt-3">
							<div class="row">
								<div class="col">
									<label>slug :</label>
									 {{$event->slug}}
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
									<label>Type :</label>
									<span  class="badge text-white" id="event_type_span"> {{$event->type}} </span>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
								<label>Venue :</label>
									
									 {{$event->venue}}
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
								<label>Max members :</label>
									
									 {{$event->max_members}}
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
									<label>Start Date-Time</label>
									 {{--(new Carbon($event->start_at))->toDateTimeString()--}}
									 {{(new Carbon\Carbon($event->start_at))->format(' jS \\of F Y h:i A')}}
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
									<label>End Date-Time</label>
									 {{--(new Carbon($event->start_at))->toDateTimeString()--}}
									 {{(new Carbon\Carbon($event->end_at))->format(' jS \\of F Y h:i A')}}
								</div>
							</div>
							<div class="row">
								<div class="col mt-3 " style="color: rgba(0,0,0,.84); ">
									<label>Description :</label>
									<p>
										{!!$event->description!!}
									</p>
								</div>
							</div>

							
							<div class="row">								
									<div class="col-md-12 mt-5">
										<label>Members joined ({{$event->event1_members->count()}})</label>
										<ul class="list-unstyled">
										@foreach($event->event1_members as $member)
											<li><img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "?s=50&d=retro" }}" class=" card-img img-circle bg-primary card_shadow" height="30" width="30">{{$member->user->name}}[{{$member->user->roll_no}}]
											</li> 
										@endforeach
										</ul>
									</div>
								
							</div>
					
							<div class="row">								
								<div class="col-md-12 mt-5">
									<label>Members Interested ({{$interested_members->count()}})</label>
									<ul class="list-unstyled">
									@foreach($interested_members as $member)
										<li><img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "?s=50&d=retro" }}" class=" card-img img-circle bg-primary card_shadow" height="30" width="30">{{$member->user->name}}[{{$member->user->roll_no}}]
										</li> 
									@endforeach
									</ul>
								</div>
							
							</div>

							@if(!($event->trashed()))
									@if(!($event->event1_members()->withTrashed()->where('user_id', Auth::user()->id)->first()))						
										<div class="row action_btns">
		    								<div class="col-md-5 mt-4" >
												<button type="button"  class="btn btn-outline-dark btn-block btn-sm interest_btn" value="interested">interested </button>
											</div>
											<div class="col-md-5 mt-4" >
												<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="join">join</button>
											</div>
										</div>
									@elseif($event->event1_members()->onlyTrashed()->where('user_id', Auth::user()->id)->first() )
										<div class="row action_btns">
		    								<div class="col-md-5 mt-4" >
												<button type="button"  class="btn btn-outline-dark btn-block btn-sm interest_btn" value="uninterested"><i class="fas fa-check"></i> interested </button>
											</div>
											<div class="col-md-5 mt-4" >
												<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="join">join</button>
											</div>
										</div>	

									@elseif($event->event1_members()->where('user_id', Auth::user()->id)->first())
										<div class="row action_btns">						
											<div class="col-md-5 mt-4" >
												<button type="button"  class="btn btn-outline-dark btn-block btn-sm interest_btn" value="interested" disabled="disabled"> interested </button>
											</div>
											<div class="col-md-5 mt-4" >
												<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="unjoin"><i class="fas fa-check"></i> joined</button>
											</div>
										</div>
									@endif	
							@endif	
								
						</div>

					</div>

					<div class="row">
						<div class="col-md-12 text-center">
							<hr>	
							<h1>Comments</h1>
							<div id="disqus_thread"></div>
							<script>
							
							var disqus_config = function () {
							this.page.url = '{{Request::url()}}';  //  page's canonical URL variable
							this.page.identifier = {{$event->id}}; // unique identifier variable
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
				<div class="col-md-3">
			
					@if($event->user_id == Auth::user()->id)
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
			                  	<!--
			                    <div class="col-md-6">
			                      <a href="{{--route('user.events.edit', $event->id)--}}" class="btn btn-primary btn-sm btn-block">edit </a>
			                    </div> -->
			                    @if(!($event->trashed()))	
			                    <div class="col-md-6">
			                    	<a class="btn btn-outline-danger btn-sm btn-block" data-toggle="modal" data-target="#myModal" href="#">delete </a>
			                      
			                    </div>
			                    @endif
			                  </div>
			                </div>

		              	</div>
	              	@endif
	            

	              	<div class="row">
	              		<div class="col-md-11 offset-md-1 mt-4   bg-white"  style="font-size: 0.8rem">
	              			<h5 class="mt-2">Popular Events:</h5>
	              			<ul  class="nav nav-tabs list-group mt-3 ">
	              				@foreach($popular_events as $pop_event)
							  <li class="nav-item list-group-item">
							    <a class="nav-link " href="{{route('user.events.show',  $pop_event->id)}}">
							   	{{($loop->index + 1).'. '.$pop_event->title }}
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
<script id="dsq-count-scr" src="//studentportal-1.disqus.com/count.js" async></script>
<script type="text/javascript">

	$(document).ready(function(){
		
		

		eventType = '{{$event->type}}'

		if(eventType == 'study')
			$('#event_type_span').css('background-color', '#7F0180')
		else if(eventType == 'entertainment')
			$('#event_type_span').css('background-color', '#007F00')
		else
		$('#event_type_span').css('background-color', '#d50000')

		$(document).on('click', '.action_btns button', function(){
			var action = $(this).val(); 
			//id = $(this).parent().parent().next().val();
			var thisBtn= $(this);	
			$.ajax({
		    	type :'GET',
		        url : '{{route('user.events.action')}}',
		       
		        data:{	'token' : '{{csrf_token()}}',
		        	'action' : action,
		               'id' : {{$event->id}}
				 },

				success : function(data1)
				{
					//console.log(data1);
					if(action == 'join')
					{
						thisBtn.html('<i class="fas fa-check"></i> joined')
						thisBtn.val('unjoin')

						thisBtn.parent().parent().find('.interest_btn').html('interested');
						thisBtn.parent().parent().find('.interest_btn').val('interested');
						thisBtn.parent().parent().find('.interest_btn').attr('disabled', 'disabled');

					} 
					else
					if(action == 'interested')
					{
						thisBtn.html('<i class="fas fa-check"></i> interested')
						thisBtn.val('uninterested')
					}else
					if(action == 'unjoin')
					{
						thisBtn.html('join')
						thisBtn.val('join')
						thisBtn.parent().parent().find('.interest_btn').attr('disabled', false);

						
					}else
					if(action == 'uninterested')
					{
						thisBtn.html('interested')
						thisBtn.val('interested')
					}

				},
				error : function(data2)
				{
					console.log(data2);
				}		
			});
		});
	});
	function comment_notify(comment_id, comment_text)
		{
			//comment_notify1(comment_id, comment_text);
			$.ajax({
				type :'GET',
		        url : '{{route('user.comments.notifyComment')}}',
		       
		        data:{	'token' : '{{csrf_token()}}',
		        		'primary_id': '{{$event->id}}',
		        		'comment_id' : comment_id,
		               'model' : 'Event1'
					 },
				success : function(data){
					console.log(data)
				},
				error : function(err){
					console.log(err);
				}	 
			});
		}

</script>
@endsection