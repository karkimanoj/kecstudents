
@extends('layouts.app')

@section('content')

<div class="main-container">

    <!-- heading -->
	<div class="container-fluid w-100" id="top_header" > 												 <h2 class="text-center">All Notices</h2>
	</div>	

    <div class="row">
      <div class="col-md-8 offset-md-2">
      	@foreach($notices as $notice)
        <div class="card mt-3 mb-3">
            <div class="card-body">
              <h5 class="card-title"><a href="{{route('notice.show', $notice->id)}}" class="card-link">{{$notice->title}}</a></h5>
              <h6 class="date">{{$notice->created_at->toFormattedDateString()}}</h6>
              <p class="card-text">{!! $notice->content !!}</p>
            </div>
        </div> 
        @endforeach                
      </div>
    </div>
    
    <center>{{ $notices->links( "pagination::bootstrap-4") }}</center>
</div>


@endsection