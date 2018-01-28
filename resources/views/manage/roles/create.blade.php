



@extends('layouts.manage')

@section('content')
	<div class="main-container">

		<div class="row m-b-20">
			<div class="col-md-6">
				<div class="page-header">
				  <h1>Create new Role</h1>
				</div>
			</div>			
			<div class="col-md-4 col-md-offset-2 ">
				<a href="{{ route('roles.index') }}" class="btn  btn-primary pull-right"> View all roles</a>
			</div>
		</div>

		<form method="POST"  action="{{route('roles.store')}} ">
                        {{csrf_field()}}
			<div class="row">
				<div class="col-md-10">
						<div class="panel panel-info m-l-5">
							  <div class="panel-heading">
							    <h3>role details:</h3>
							  </div>
							  <div class="panel-body">
							    
			                        <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
			                            <label> Name </label>
			                            <input type="text" name="name" class="form-control"    minlength="5" maxlength="100">
			                            @if($errors->has('name'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('name') }}</strong>
		                                    </span>
                                        @endif
			                        </div>
			                        <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
			                            <label>Display name </label>
			                            <input type="text" name="display_name" class="form-control" required minlength="5" maxlength="100">
			                            @if($errors->has('display_name'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('display_name') }}</strong>
		                                    </span>
                                        @endif
			                        </div>
			                        <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
			                            <label> Description </label>
			                            <input type="text" name="description" class="form-control" required minlength="8" maxlength="190">
			                            @if($errors->has('description'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('description') }}</strong>
		                                    </span>
                                        @endif
			                        </div>
							    <h3>select permissions for this role:</h3>
							  </div>
							  @foreach($permissions as $permission)
								  <li class="list-group-item borderless" >
								  	<input type="checkbox" name="permission_checks[]" value="{{$permission->id}}">
								  	{{$permission->display_name}}
								  	<i class="text-muted" >({{$permission->description}})</i>
								  </li>
								@endforeach 
							  <button type="submit" class="btn btn-primary btn-lg btn-block m-t-20">create new role</button>
						</div>	  

				</div>
			</div>
		</form>		
	
		
	</div>
@endsection


                         