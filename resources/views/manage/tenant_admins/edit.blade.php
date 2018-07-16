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
                        <form method="POST" action="{{route('tenantAdmin.update', $tenant_admin->id)}} ">
                                {{method_field('PUT')}}
                                {{csrf_field()}}
                            
                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Name</label>
                                        <input type="text" name="name"  class="form-control" value="{{$tenant_admin->name}}" required maxlength="100">
                                       
                                    </div>

                                    <div class="form-group {{ $errors->has('email')?'has-error':'' }} mtop-5">
                                        <label >Email address</label>
                                        <input type="email" name="email"  class="form-control" value="{{$tenant_admin->email}}" required maxlength="100">
                                       
                                    </div>

                                    <div class="form-group " >
                                         <div class="radio">
                                          <label><input type="radio" name="passedit_radio" value="keep"  checked > Do not change password</label>
                                        </div>

                                        <div class="radio">
                                          <label><input type="radio" name="passedit_radio"  value="auto" > Auto generate Password</label>
                                        </div>
                                        
                                        <div class="radio">
                                          <label><input type="radio"  name="passedit_radio"  value="manual" > Manual Password</label>
                                        </div>
                                    </div>


                                    <div class="form-group mt-2{{ $errors->has('password')?'has-error':'' }} ">
                                        <label >Password</label>
                                        <input type="password" name="password" id="manage_password" disabled class="form-control" required minlength="8" >
                                       
                                    </div>
                                    <div class="form-group ">
                                        <input type="submit" name="update" class="btn btn-primary btn-block">
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