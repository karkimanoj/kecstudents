@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-8 col-md-offset-2 ">
        	<h2><center>Create New Faculty</center></h2>
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" action="{{route('faculties.store')}} ">
                                {{csrf_field()}}    
                                        
                                <div class="form-group {{ $errors->has('name')?'has-error':'' }} mtop-5">
                                    <label >Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required maxlength="100">
                                    @if($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group mtop-5{{ $errors->has('display_name')?'has-error':'' }} ">
                                    <label >Display Name</label>
                                    <input type="text" name="display_name" class="form-control" required maxlength="255">
                                    @if($errors->has('display_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('display_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group ">
                                        <input type="submit" name="create" class="btn btn-primary btn-block">
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