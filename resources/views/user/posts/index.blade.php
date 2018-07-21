



@extends('layouts.app')

@section('content')

<div class="main-container">
		<!-- heading -->
		<div class="row ml-0 mr-0">
			<div class="col-md-12" id="top_header" >
				
				 <h2 class="text-center">All User Posts</h2>
				 <div class="row">
				 	<div class="col-md-8 offset-md-2">
				 		<div class="input-group input-group-lg">
							  <input type="text" class="form-control" placeholder="search" aria-label="Large" aria-describedby="basic-addon2">
							  <div class="input-group-prepend"> 
							  	<button class="btn btn-default" type="button" id="basic-addon2">
							  	<i class="fas fa-search" style="color:#228AE6"></i> osts
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
								<h4 class="text-muted"> Displaying {{$posts->count()}} results </h4>
							</div>
							
						</div>

						<div class="row ">
							<div class="col-md-12 mt-3">
								@foreach($posts as $post)

								<div class="row mt-3" id="posts_box">

									<div class="col-md-auto v_align_inner_div" >
										<div class="container">
											<div class="row">
												<div class="col-md-12">
													<i class="fas fa-comments fa-3x " ></i>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12 text-center" style=" font-size: 2em;">
													7
												</div>
											</div>
										</div>	
										
										<!--
											<div class="container v_align_inner_div" style="border: 1px solid black;">
											</div>
										<div class="container" style="height:50%; border: 1px solid black;">
											
										</div>-->
										
									
											
									</div>
								    <div class="col-md-9 card  "  style="border: 1px solid black">
									
								    
								    	<div class="card-body">
								    	<div class="row" >
								    		<div class="{{($post->imgs()->first()->filepath)? 'col-md-8' : 'col-md-12'}}" >
								    			
								    		
									    	<div class="row ">
									    		<div class="col-md-12" >
									    			<a href="{{route('user.posts.show', $post->slug)}}" id="post_name" 
    											>{{$post->content}}</a>
									    		</div>
									    	</div> 

									    	<div class="row ">
									    		<div class="col text-muted" >
									    			<small>
									    			By: {{ $post->user->name }} <i> [ {{ $post->user->roll_no }} ]</i>, {{($post->created_at )->diffForHumans(Carbon\Carbon::now()) }}
									    			{{-- ->toFormattedDateString() --}}
									    			</small>
									    		</div>
									    		
									    	</div>

											<div class="row ">
												<div class="col">
													<ul class="list-inline">
														
													@foreach($post->tags as $tag)
													  <li class="list-inline-item">
													  	<span class="badge badge-success">{{$tag->name}}
													  	</span>
													  </li>
													@endforeach
													</ul>
												</div>
											</div>		
							   			</div>

							   			@if($post->imgs()->first()->filepath)
							   			<div class="col-md-4" >
							   				<img src="{{asset($post->imgs()->first()->filepath)}}" alt="aa" class="img-thumbnail">
							   			</div>
							   			@endif
							   		    </div>
								    	</div>

							   		</div>
							    
							    	<div class="col-md-auto">
							    		<div class="container">
							    			<a href="{{route('user.posts.edit', $post->slug)}}">
							    			<i class="fas fa-edit"></i></a>
							    		</div>
							    		<div class="container">
							    			<i class="fas fa-trash-alt"></i>
							    		</div>
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
					                      <span class="badge ">{{Auth::user()->projects->count()}}</span><br>
					                      <a class="nav-link active" href="{{route('user.projects.index')}}"><h7>Projects<h7> </a>
					                    </li>
									  <li class="nav-item">
									  	<span class="badge ">{{Auth::user()->downloads->count()}}</span><br>
									    <a class="nav-link active" href="{{route('user.posts.index')}}"><h7>downloads<h7> </a>
									  </li>
									  <li class="nav-item">
									  	 <span class=" badge badge-light">31</span><br>
									    <a class="nav-link" href="#">Events</a>
									  </li>
									 
									  <li class="nav-item">
									  	<span class="badge badge-light">31</span><br>
									    <a class="nav-link" href="#">posts </a>
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
						  <a href="{{route('user.posts.create')}}" class=" btn btn-outline-primary btn-block ">Upload New File/s</a>
			              <a href="#" class=" btn btn-outline-primary btn-block ">Create New event</a>
			              <a href="#" class=" btn btn-outline-primary btn-block ">Create New post</a>
					  </div>
					</div>
			</div>
		</div>
	</div>
 </div>

	
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function ()
	{
		$(function () {
		  $('[data-toggle="popover"]').popover();
		})
	});
</script>
@endsection