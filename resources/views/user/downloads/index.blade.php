



@extends('layouts.app')

@section('content')

<div class="main-container">
		<!-- heading -->
		<div class="row ml-0 mr-0">
			<div class="col-md-12" id="top_header" >
				
				 <h2 class="text-center">All User Uploads</h2>
				 <div class="row">
				 	<div class="col-md-8 offset-md-2">
				 		<div class="input-group input-group-lg">
							  <input type="text" class="form-control" placeholder="search" aria-label="Large" aria-describedby="basic-addon2">
							  <div class="input-group-prepend"> 
							  	<button class="btn btn-default" type="button" id="basic-addon2">
							  	<i class="fas fa-search" style="color:#228AE6"></i> Downloads
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
								<h4 class="text-muted"> Displaying {{$downloads->count()}} results </h4>
							</div>
							
						</div>

						<div class="row ">
							<div class="col-md-12 mt-3">
								@foreach($downloads as $download)
								<div class="row m-t-30" id="downloads_box">

									<div class="col-md-auto v_align_inner_div" >
										<div class="container">
											<div class="row">
												<div class="col-md-12">
													<i class="fas fa-comments fa-3x " ></i>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12 text-center" style=" font-size: 2em;">
												<a href="{{route('user.downloads.show', $download->id)}}#disqus_thread" data-disqus-identifier="{{$download->id}}"> 0</a>
												</div>
											</div>
										</div>	
									</div>	

								  <div class="col-md-9  border_purple" style=" padding: 0px 20px 15px 20px;" >
									
									    

									    	<div class="row m-t-10">
									    		<div class="col-md-12" >
									    			<a href="{{route('user.downloads.show', $download->id)}}" id="download_name" 
    											>{{$download->title}}</a>
									    		</div>
									    	</div> 
									    	<div class="row m-t-10">
									    		<div class="col-md-6" >
									    			<i class="fas fa-user"></i> 
									    			{{ $download->user->name }}
									    		</div>
									    		<div class="col-md-6" >
									    			<i class="far fa-clock"></i>
									    			<span>{{ $download->created_at->toFormattedDateString() }}
									    				</span>
									    		</div>
									    	</div>
									    	<div class="row m-t-10">
									    		<div class="col-md-6 mt-1" >
									    			<button class="btn btn-info btn-sm">{{ $download->download_files->count() }} file/s</button>						
									    		</div>
									    		<div class="col-md-6 mt-1" >
									    			<button type="button" class="btn btn-sm btn-info" data-toggle="popover" title="Description"  data-content="{{ $download->description }}">description</button>
									    		</div>
									    	</div>
								  </div>
								  @if( Auth::user()->owns($download, 'uploader_id') )
       							  
								  	<div class="col-md-auto">
							    		<div class="container mt-2">
							    			<a href="{{route('user.downloads.edit', $download->id)}}">
							    			<i class="fas fa-edit"></i></a>
							    		</div>
							    		<div class="container mt-2">
							    			<a id="delete_btn{{($download->id)*2}}"  data-toggle="modal" data-target="#myModal" href="#"> <i class="fas fa-trash-alt" ></i></a>
							    			<input type="hidden" value="{{route('user.downloads.destroy',$download->id)}}">
							    		</div>
							    	</div>
							    	@endif

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
                  <a href="{{route('user.downloads.create')}}" class=" btn btn-outline-primary btn-block ">upload new materials</a>
                  
                   <a href="{{route('user.posts.create')}}" class=" btn btn-outline-primary btn-block ">create new post</a>
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