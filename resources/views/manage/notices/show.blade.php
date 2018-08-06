@extends('layouts.manage')
			
@section('content')

<div class="main-container">
			
	<div class="row">
		<div class="col">
			<h1><center>{{$notice->title}}</center></h1>
		</div>
	</div>
		
	<div class="row">
		
		<div class="col-md-10 offset-md-2">
			<div class="row">
				<div class="col">
					<label > content: </label>
					<p class="text-justified"> {!!$notice->content!!}</p>
				</div>
			</div>
			
			@if(count($notice->imgs))

			
			<div class="row">
				<div class="col form-group">
					<label>Images: </label><br>
				@foreach($notice->imgs as $img)
				<img src="{{asset($img->filepath)}}" class="img-fluid mt-2" alt="Responsive image">
				@endforeach
			</div>
			</div>
			
			@endif
			<center><a class="btn-lg btn-info mt-2" href="{{route('notices.index')}}" role="button" >All Notices</a></center>
		</div>
		
	</div>
								
						
</div>
				
@endsection		