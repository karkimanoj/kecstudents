
@extends('layouts.app')

@section('content')
	<div class="main-container bg_grey">
	    <div class="container-fluid" id="top_header" >
          	<h2 class="text-center">View Download</h2>
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
			        			<form method="POST" action="{{ route('downloads.destroy', $download->id) }}" >
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
							<h4 >{{$download->title}}</h4> 
							<div class="row" style="font-size: 0.9rem">
								<div class="col-md-6">
									<i class="fas fa-user" ></i> <span class="text-primary">{{$download->user->name}} <i>[{{$download->user->roll_no}}]</i></span>
								</div>
								<div class="col-md-6">
									<i class="fab fa-cuttlefish" ></i> <span class="text-muted">{{$download->download_category->name}}</span>

								</div>
							</div>
							<div class="row mt-2" style="font-size: 0.9rem">
								<div class="col-md-6">
									<i class="far fa-clock" ></i> <span class="text-muted">{{$download->published_at}}</span>
								</div>
								<div class="col-md-6">
									<i class="far fa-clock" ></i> <span class="text-muted">{{$download->created_at->toFormattedDateString()}}</span>

								</div>
							</div>
							<hr>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">

							<div class="row mt-4" >
								<div class="col">
									<i class="fas fa-comments fa-3x"></i> <span style="font-size: 2rem;"><a href="{{Request::url().'#disqus_thread'}}">0</a></span>
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

									<!--<i class="fab fa-cuttlefish" ></i>-->
									{!! ($download->download_category->category_type == 'subject') ? '<label> Subject : </label> '.$download->subject->name : '<label> Faculty / Semester : </label>'.$download->faculty->name.' - '.$download->semester!!}
									 
								</div>
									
									
							</div>

							<div class="row">
								<div class="col mt-3 " style="color: rgba(0,0,0,.84); ">	
									<label>Description :</label><br>
									<p class="text-center">
										{!!$download->description!!}
									</p>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 mt-3">
									<label> {{$download->download_files->count()}} file/s <label>
									<table class="table  visible">
									  <thead>
									    <tr>
									      
									      <th scope="col">Files</th>
									      <th scope="col">Download</th>
									   
									    </tr>
									  </thead>
									  <tbody>
									  	@foreach($download->download_files as $file)
									  	<tr>
									  		<th scope="row"><a href="{{asset($file->filepath)}}"> {{$file->display_name}} </a></th>
										     
										     <td><a class="btn btn-info" href="{{asset($file->filepath)}}"> download </a></td>
									  	</tr>
									  	@endforeach
									  </tbody>
									</table>  
										
											
										
										
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
								this.page.identifier = {{$download->id}}; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
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
					@if( $download->uploader_id == Auth::user()->id && Auth::user()->hasRole('teacher'))
						<div class="card  card_shadow w-100 borderless mt-4" id="user_widget">
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
		                
			                <div class="card-footer bg-white borderless">
			                  <div class="row">
			                    <div class="col-md-6">
			                      <a href="{{route('user.downloads.edit', $download->id)}}" class="btn btn-primary btn-sm btn-block">edit </a>
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
	              			<h5 class="mt-2">Popular Downloads:</h5>
	              			<ul  class="nav nav-tabs list-group mt-3 ">
	              				@foreach($popular_downloads as $pop_download)
							  <li class="nav-item list-group-item">
							    <a class="nav-link " href="{{route('user.downloads.show',  $pop_download->id)}}">
							   	{{($loop->index + 1).'. '.$pop_download->title }}
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
		        		'primary_id': '{{$download->id}}',
		        		'comment_id' : comment_id,
		               'model' : 'Download'
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
