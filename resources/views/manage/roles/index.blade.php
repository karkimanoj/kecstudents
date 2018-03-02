



@extends('layouts.manage')

@section('content')
	<div class="main-container">

		<div class="row m-b-20">
			<div class="col-md-4">
				<center><h1>Roles</h1></center>
			</div>
			<div class="col-md-4 offset-md-4 ">
				<a href="{{ route('roles.create') }}" class="btn  btn-primary float-right"> create new role</a>
			</div>
		</div>

		<div class="row">
			@foreach($roles as $role)
				
			<div class="col-md-4">
				<div class= "card mt-3 mb-3">
				  <h5 class="card-header">{{$role->name}}</h5>
				  <div class="card-body">
				    <h5 class="card-title">{{$role->display_name}}</h5>
				    <p class="card-text">{{$role->description}}</p>
				    <div class="row m-b-10">
						 <div class="col-md-4 offset-md-1 m-t-10 text-center "> <a href="{{route('roles.show', $role->id)}}" class="btn btn-primary btn-block">details</a></div>
						  <div class="col-md-4 offset-md-1 m-t-10 text-center"><a href="{{route('roles.edit', $role->id)}}" class="btn btn-outline-primary">edit</a></div>
					 
					</div>  
				  </div>
				</div>
			</div>
				@endforeach

		</div>
	</div>
@endsection


