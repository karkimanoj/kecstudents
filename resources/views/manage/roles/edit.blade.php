



@extends('layouts.manage')

@section('content')
	<div class="main-container">

		<div class="row m-b-20">
			<div class="col-md-6">
				<div class="page-header">
				  <h1>Edit {{$role->name}}</h1>
				</div>
				<h3 class="text-muted">{{$role->description}}</h3>
			</div>			
			<div class="col-md-4 col-md-offset-2 ">
				<a href="{{ route('roles.edit', $role->id) }}" class="btn  btn-primary pull-right"> Edit role</a>
			</div>
		</div>

		<form method="POST"  action="{{route('roles.update', $role->id)}} ">
                        {{csrf_field()}}
                        {{method_field('PUT')}};
			<div class="row">
				<div class="col-md-10">
						<div class="panel panel-info m-l-5">
							  <div class="panel-heading">
							    <h3>role details:</h3>
							  </div>
							  <div class="panel-body">
							    
			                        <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
			                            <label> Name </label>
			                            <input type="text" name="name" class="form-control" value="{{$role->name}}" disabled  minlength="5" maxlength="100">
			                        </div>
			                        <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
			                            <label>Display name </label>
			                            <input type="text" name="display_name" class="form-control" value="{{$role->display_name}}" required minlength="5" maxlength="100">
			                        </div>
			                        <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
			                            <label> Description </label>
			                            <input type="text" name="description" class="form-control" value="{{$role->description}}" required minlength="8" maxlength="190">
			                        </div>
							    <h3>Permission details:</h3>
							  </div>
							  @foreach($permissions as $permission)
								  <li class="list-group-item borderless" >
								  	<input type="checkbox" name="permission_checks[]" value="{{$permission->id}}">
								  	{{$permission->display_name}}
								  	<i class="text-muted" >({{$permission->description}})</i>
								  </li>
								@endforeach 
							  <button type="submit" class="btn btn-primary btn-lg btn-block m-t-20">update role</button>
						</div>	  

				</div>
			</div>
		</form>		
	
		
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			var role_permissions=[
							@foreach($role->permissions as $r_permissions)
								"{{$r_permissions->id}}",
							@endforeach
							];

			$.each($("input[name='permission_checks[]']"), function() {

						for (var i = 0; i < role_permissions.length; i++) 
						{
							if($(this).val()==role_permissions[i])
							{
								$(this).prop('checked',true);
							}
						}
						
                        
                       //$('#permission_list').append('<li class="list-group-item">'+
                       // $(this).val()+'-'+resource_val+'</li>');
                    }); //alert(role_permissions);
		});
	</script>
@endsection
                         