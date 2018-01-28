@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-12 block-center  ">
        	<h2><center>Edit User</center></h2>
              <div class="panel panel-default m-l-20">
                    <div class="panel-body">
                        <form method="POST" action="{{route('users.update', $user->id)}} ">
                                {{method_field('PUT')}}
                                {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Name</label>
                                        <input type="text" name="name"  class="form-control" value="{{$user->name}}" required maxlength="100">
                                       
                                    </div>

                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Email address</label>
                                        <input type="email" name="email"  class="form-control" value="{{$user->email}}" required maxlength="100">
                                       
                                    </div>

                                    <div class="form-group " >
                                         <div class="radio">
                                          <label><input type="radio" name="passedit_radio" value="keep"  checked >Do not change password</label>
                                        </div>

                                        <div class="radio">
                                          <label><input type="radio" name="passedit_radio"  value="auto" >Auto generate Password</label>
                                        </div>
                                        
                                        <div class="radio">
                                          <label><input type="radio"  name="passedit_radio"  value="manual" >Manuall Paaword</label>
                                        </div>
                                    </div>


                                    <div class="form-group mtop-5{{ $errors->has('password')?'has-error':'' }} ">
                                        <label >Password</label>
                                        <input type="password" name="password" id="manage_password" disabled class="form-control" required minlength="8" >
                                       
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

            var user_roles=[@foreach($user->roles as $role)
                                "{{$role->id}}",
                             @endforeach   
                           ];
            //alert(user_roles);
            $.each($("input[name='roles[]']"), function() {

                        for (var i = 0; i < user_roles.length; i++) 
                        {
                            if($(this).val()==user_roles[i])
                            {
                                $(this).prop('checked',true);
                            }
                        }
                
            });

			function check_checkbox(){

                var radio_value=$("input[name=passedit_radio]:checked").val();
                //alert(radio_value);
				if(radio_value=='keep' || radio_value=='auto')
				   $('#manage_password').prop('disabled', true);
			    else  
				  $('#manage_password').prop('disabled', false);
			}

            check_checkbox();
			$('input[name=passedit_radio]').click( function(){
				check_checkbox();
				});	


			});	
	</script>
@endsection