



@extends('layouts.manage')

@section('content')
	<div class="main-container">
		<div class="row m-b-20">
			<div class="col-md-10">
				<div class="page-header">
				  <h1>{{$role->display_name}} <small > <i>({{$role->name}})</i></small></h1>
				</div>
				<h4 class="text-muted">{{$role->description}}</h4>
			</div>			
			<div class="col-md-2">
				<a href="{{ route('roles.edit', $role->id) }}" class="btn  btn-primary btn-block pull-right"> Edit role</a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-10">
				
				<div class="card">
				  <div class="card-block">
				    <h2 class="card-title"> Permissions:</h2>
				    <p >
						<ol class="list-group">
							@foreach($role->permissions as $permission)
							  <li class="list-group-item borderless">
							  	<i class="fa fa-circle" aria-hidden="true"></i>
							  	{{$permission->display_name}}
							  	<i class="text-muted">({{$permission->description}})</i>
							  </li>
							@endforeach  
						</ol>
				    	
				    </p>
				    
				  </div>
				</div>
				
				</div>
			</div>
		</div>
	</div>
@endsection


