@extends('layouts.tenantAdmin')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-11 m-l-20 ">
        	<h2><center>Create New Admin</center></h2>
            <div class="row">
              <div class="col-md-6 offset-md-3">   
              <div class="card card-default">
                    <div class="card-body">
                        <form method="POST" action="{{route('tenantAdmin.store')}} ">
                                {{csrf_field()}}

                                 
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

                                    <div class="form-group mt-2{{ $errors->has('password')?'has-error':'' }} ">
                                        <label >Password</label>
                                        <input type="password" name="password" id="manage_password" disabled class="form-control" required minlength="8" >
                                       
                                    </div>
                                    <div class="form-group mt-2{{ $errors->has('password_confirmation')?'has-error':'' }} ">
                                        <label >password_confirmation</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" disabled class="form-control" required minlength="8" >
                                       
                                    </div>

                                    <div class="form-group " >
                                        <input type="checkbox"  id="checkbox_auto_password"  checked> Auto generate password
                                    </div>
                                    <div class="form-group ">
                                        <input type="submit" name="submit" value="Create" class="btn btn-primary btn-block">
                                </div>
                            
                           
                        </form>   
                        </div>
                        </div> 
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
					   {
					   $('#manage_password, #password_confirmation').prop('disabled', true);

                       }
				    else 
                    {
					  $('#manage_password, #password_confirmation').prop('disabled', false);
                    }
			}

			$('#checkbox_auto_password').click( function(){
				check_checkbox();
				});	

			});	
	</script>
@endsection