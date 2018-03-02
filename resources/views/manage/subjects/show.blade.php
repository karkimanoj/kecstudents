@extends('layouts.manage')

@section('content')
	<div class="main-container">

		<div class="row">
			<div class="col-md-4">
				<h1>subjects</h1>
			</div>
			<div class="col-md-4 offset-md-4 ">
				<a href="{{ route('subjects.edit', $subject->id) }}" class="btn  btn-primary float-right"> Edit subject</a>
			</div>
		</div> <!--end of ro-->

		<div class="row">
			<div class="col-md-8  m-t-20">
				<div class="panel panel-default">
				  <div class="panel-body">
						<p>
							<label>Name:</label>
							<span>{{$subject->name}}</span>
						</p>
						<p>
							<label>project?:</label>
							<span>@if($subject->project==1)
								yes
								@else
								no
							@endif</span>
						</p>

						<h3>faculty/semester</h3>
						<ul>
							@foreach($subject->faculties as $faculty)
							<li>
								{{$faculty->name}}-{{$faculty->pivot->semester}}
							  </li>
							@endforeach
						</ul>
				  </div>
				</div>
				
			</div>
		</div> <!--end of ro-->

	</div>	
@endsection



