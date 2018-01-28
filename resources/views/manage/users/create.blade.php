@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-11 m-l-20 ">
        	<h2><center>Create New User</center></h2>
              <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="POST" action="{{route('users.store')}} ">
                                {{csrf_field()}}

                            <div class="row">
                                <div class="col-md-6">        
                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Name</label>
                                        <input type="text" name="name"  class="form-control" required  maxlength="100">
                                       
                                    </div>

                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Email address</label>
                                        <input type="email" name="email"  class="form-control" required maxlength="100">
                                         @if($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                       
                                    </div>

                                    <div class="form-group mtop-5{{ $errors->has('password')?'has-error':'' }} ">
                                        <label >Password</label>
                                        <input type="password" name="password" id="manage_password" disabled class="form-control" required minlength="8" >
                                       
                                    </div>

                                    <div class="form-group " >
                                        <input type="checkbox"  id="checkbox_auto_password"  checked> Auto generate password
                                    </div>

                               </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <h4 class="list-group-item-heading">Roles:</h4>
                                        @foreach($roles as $role)
                                            <li class="list-group-item borderless">
                                                <input type="checkbox" name="roles[]" value="{{$role->id}}">
                                                {{$role->display_name}}
                                                <i class="text-muted">({{$role->description}})</i>
                                            </li>
                                        @endforeach    
                                    </ul>

                                </div>
                                <div class="form-group col-md-6">
                                        <input type="submit" name="update" class="btn btn-primary btn-block">
                                </div>
                           </div>
                           
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){

			function check_checkbox(){
					if($("#checkbox_auto_password").prop("checked"))
					   
					   $('#manage_password').prop('disabled', true);
				    else 
					  $('#manage_password').prop('disabled', false);
			}

			$('#checkbox_auto_password').click( function(){
				check_checkbox();
				});	

			});	
	</script>
@endsection