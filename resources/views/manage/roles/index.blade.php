



@extends('layouts.manage')

@section('content')
	<div class="main-container">

		<div class="row m-b-20">
			<div class="col-md-4">
				<center><h1>Roles</h1></center>
			</div>
			<div class="col-md-4 col-md-offset-4 ">
				<a href="{{ route('roles.create') }}" class="btn  btn-primary pull-right"> create new role</a>
			</div>
		</div>

		<div class="row">
			@foreach($roles as $role)
				<div class="col-md-4">
					<div class="panel panel-info m-l-5">
					  <div class="panel-heading">
					    <h4>{{$role->name}}</h4>
					    <h5 class="mb-2 text-muted">{{$role->display_name}}</h5>
					  </div>
					  <div class="panel-body panel_card">
					    {{$role->description}}
					  </div>
					 
						  <div class="row m-b-10">
							 <div class="col-md-4 col-md-offset-1 m-t-10 text-center "> <a href="{{route('roles.show', $role->id)}}" class="btn btn-primary btn-block">details</a></div>
							  <div class="col-md-4 col-md-offset-1 m-t-10 text-center"><a href="{{route('roles.edit', $role->id)}}" class="btn btn-default btn-block">edit</a></div>
						 
						</div>  
					</div>	
				</div>
				@endforeach
		</div>
	</div>
@endsection


