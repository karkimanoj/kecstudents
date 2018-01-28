



@extends('layouts.manage')

@section('content')
	<div class="main-container">
		
		<div class="row">
			<div class="col-md-8">
				<h1>show Permissions</h1>
				<div class="card">
				  <div class="card-block">
				    <h2 class="card-title">{{$permission->name}}</h2>
				    <h5 class="card-subtitle mb-2 text-muted">{{$permission->display_name}}</h5>
				    <p class="card-text">
				    	<label>description: </label><br>
				    	{{$permission->description}}
				    </p>
				    <center><a href="{{route('permissions.edit', $permission->id)}}" class="btn btn-primary">edit permission</a></center>
				  </div>
				</div>
				
				</div>
			</div>
		</div>
	</div>
@endsection


