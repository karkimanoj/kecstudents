
@extends('layouts.app')

@section('content')
	<div class="main-container bg_grey">
	    <div class="container-fluid" id="top_header" >
          	<h2 class="text-center">view post</h2>
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
			        			<form method="POST" action="{{ route('user.posts.destroy', $post->slug) }}" >
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
				<div class="col-md-9 " style="background-color: white">

					<div class="row">
						<div class="col-md-12">
							<div class="card borderless2 card_shadow mt-3">
								<div class="card-body">

									<div class="row ">
										<div class="col">
											<h3 class="post-header">{{$post->content}}</h> 
										</div>
									</div>
									

									<div class="row ">
										<div class="col">
											<span class="text-muted">{{ $post->created_at->toDateTimeString()}},  {{($post->created_at )->diffForHumans(Carbon\Carbon::now()) }}</span>
										</div>
									</div>
									<div class="row ">
										<div class="col">
											<span class="text-monospace"> By {{ $post->user->name}},  
											@foreach($post->user->roles as $role)
												
												 @if (!$loop->last)
											        {{$role->name}}|
											    @else
											    	{{$role->name}}
											    	@endif
											@endforeach
										</span>
										</div>
									</div>

									<div class="row" >
										
										<div class="col-md-auto">
											<ul class="list-inline">
												
												@foreach($post->tags as $tag)
											    <li class="list-inline-item">
											  	 <span class="badge badge-success">{{$tag->name}}
											  	 </span>
											    </li>
												@endforeach
											</ul>
										</div>
										<div class="col-md-auto">
											<i class="fas fa-eye fa-lg"></i> <span class="text-primary">{{$post->view_count}} 
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											@if(count($post->imgs))
											 <img src="{{asset($post->imgs()->first()->filepath)}}"  width="100%" class="img-fluid" alt="Responsive image">
											@endif 
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							
							<div id="disqus_thread">
								<script>

								
								var disqus_config = function () {
								this.page.url = '{{Request::url()}}';  // Replace PAGE_URL with your page's canonical URL variable
								this.page.identifier = {{$post->id}}; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
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

					@if(Auth::user()->owns($post, 'author_id'))
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
			                      <a href="{{route('user.posts.edit', $post->slug)}}" class="btn btn-primary btn-sm btn-block">edit </a>
			                    </div>
			                    <div class="col-md-6">
			                    	<a class="btn btn-outline-danger btn-sm btn-block" data-toggle="modal" data-target="#myModal" href="#">delete </a>
			                      
			                    </div>

			                  </div>
			                </div>

		              	</div>
	              	@endif

	              	<div class="row">
	              		<div class="col-md-11 offset-md-1 mt-4   bg-white"  style="font-size: 0.8rem">
	              			<h5>popular posts:</h5>
	              			<ul  class="nav nav-tabs list-group mt-3 ">
	              				@foreach($popular_posts as $pop_post)
							  <li class="nav-item list-group-item">
							    <a class="nav-link " href="{{route('user.posts.show', $pop_post->slug)}}">
							   	{{($loop->index + 1).'. '.substr(strip_tags($pop_post->content ),0,60) }} <span style="color: blue"> {{ strlen(strip_tags($pop_post->content ))>60?'....?':'' }}<br>
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
		        		'primary_id': '{{$post->id}}',
		        		'comment_id' : comment_id,
		               'model' : 'Post'
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


