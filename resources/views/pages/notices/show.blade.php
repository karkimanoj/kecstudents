@extends('layouts.app')
			
@section('content')

<div class="main-container">
	
	 <!-- heading -->
	<div class="container-fluid w-100" id="top_header" > 												 
		<h2 class="text-center">View Notice</h2>
	</div>	


		
	<div class="row">
		
		<div class="col-md-9 offset-md-1">
			
			<div class="card  mb-3">
	            <div class="card-body">
	              <h5 class="card-title">{{$notice->title}}</h5>
	              <h6 class="date">{{$notice->created_at->toFormattedDateString()}}</h6>
	              <p class="card-text"><i>{!! $notice->content !!}</i></p>
	            </div>
	            @if(count($notice->imgs))
	            @foreach($notice->imgs as $img)
	           	 <img class="card-img-bottom" src="{{asset($img->filepath)}}" alt="Card image cap">
	            @endforeach
	            @endif
	          
	        </div> 

	        <div class="row">
	        	<div class="col text-center mb-3">
	        		 <a href="{{route('notices.home')}}" class="btn btn-primary btn-lg mt-3">View All Notices</a>
	        	</div>
	        </div>

			
			
		</div>
		
	</div>
								
						
</div>
				
@endsection		