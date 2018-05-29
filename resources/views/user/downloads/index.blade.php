



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
								  <div class="col-md-8 offset-md-2  border_purple" style=" padding: 0px 20px 15px 20px;" >
									
									    

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
									    		<div class="col-md-6" >
									    			<button class="btn btn-info btn-sm">{{ $download->download_files->count() }} file/s</button>						
									    		</div>
									    		<div class="col-md-6" >
									    			<button type="button" class="btn btn-sm btn-info" data-toggle="popover" title="Description"  data-content="{{ $download->description }}">description</button>
									    		</div>
									    	</div>

									    	
											    	<div class="row m-t-10">
											    		<div class="col-md-6 " >
											    			<a href="{{route('user.downloads.edit', $download->id)}}"  class="btn btn-outline-primary btn-sm "
		    											>edit</a>
											    		</div>
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
									  	<span class="badge ">{{Auth::user()->downloads->count()}}</span><br>
									    <a class="nav-link active" href="{{route('user.downloads.index')}}"><h7>downloads<h7> </a>
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
						  <a href="{{route('user.downloads.create')}}" class=" btn btn-outline-primary btn-block ">Upload New File/s</a>
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