@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-10 offset-md-1 ">
        	<h2><center>REGISTER YOUR COLLEGE</center></h2>
            <div class="alert alert-secondary " role="alert">
                <ul>
                    <li>Multiple file select (ctrl + select max 10 files) is available only for 'note' . 
                    </li>                   
                    
                </ul>
                
            </div>
            <div class="row">
                <div class="col-md-12 file_error" >
                    
                </div>
            </div>
           
              <div class="panel panel-default mt-2">
                    <div class="panel-body">
                        <form method="POST" action="{{route('tenants.store')}} " enctype="multipart/form-data" id="form">
                                {{csrf_field()}}    
                                  
                                <div class="row form-group mt-2{{ $errors->has('name')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">Name:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <input type="text" name="name" minlength="4" class="form-control" value="{{old('name')}}" required maxlength="191">
                                         <small class="form-text text-muted">
                                          Full name of your college
                                        </small>
                                        @if($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif

                                     </div>                 
                                </div>
                                        

                                <div class=" row form-group mt-2 ">
                                    <div class="col-md-3">               
                                       <label class="right mr-2">subdomain/Identifier</label>
                                    </div>
                                    <div class="col-md-4 form-group {{ $errors->has('subdomain')?'has-error':'' }}">
                                        <input type="text" name="subdomain" minlength="4" class="form-control" value="{{old('subdomain')}}" required maxlength="191">
                                         <small class="form-text text-muted">
                                          Eg: acem for acem.edu.np
                                        </small>
                                        @if($errors->has('subdomain'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('subdomain') }}</strong>
                                            </span>
                                        @endif
                                        
                                    </div>
                                    <div class="col-md-4 form-group {{ $errors->has('identifier')?'has-error':'' }}">
                                        <input type="text" name="identifier" minlength="3" maxlength="3" class="form-control" value="{{old('identifier')}}" required >
                                         <small class="form-text text-muted">
                                          Exactly 3 letter identifier. Eg: kec for kantipur Engeenering colleg
                                        </small>
                                        @if($errors->has('identifier'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('identifier') }}</strong>
                                            </span>
                                        @endif
                                        
                                    </div>
                                </div>

                                <div class=" row form-group mt-2 {{ $errors->has('logo')?'has-error':'' }}" >
                                    <div class="col-md-3">               
                                       <label class="right mr-2">Logo</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" name="logo" class="form-control" accept="image/*" id="tenant_logo" required>
                                        <small class="form-text text-muted">
                                          Logo should be in image format with image size less than 5 MB
                                        </small>
                                        @if($errors->has('logo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('logo') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="row form-group mt-3 {{ $errors->has('description')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right mr-4">Description:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <textarea class="form-control" required rows="10" name="description" ></textarea>
                                        @if($errors->has('description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                     </div>                 
                                </div>

                                <center><input type="submit" name="submit" value="submit" class="btn btn-primary"></center>
                                
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

        var accepted_exts=['png', 'jpeg', 'jpg', 'gif'];

        $('#tenant_logo').change(function(){
            
            element=document.getElementById('tenant_logo');
            $('.file_error').empty();
            flag=true;
     
              image=element.files[0];
              imagename=image.name;
              totalSize=image.size;
              msg='';
              if(image.size > 0)
              {   
                  ext=imagename.split('.')[imagename.split('.').length-1].toLowerCase();

                  if(accepted_exts.indexOf(ext) == -1)
                  {
                      flag=false; 
                      msg+=imagename+' extension is invalid. use approprite file<br>'; 
                     
                  } 
              }else
              {   
                  flag=false; 
                  msg+=imagename+'is empty ,i.e, filesize = 0<br>'; 
              }
                
              if(totalSize > 5242880) //5242880
              {
                  flag=false; 
                  msg+=imagename+' total filesize exceeded 5 MB<br>';
              }
           
            
           
                     
            if(flag == false)
            {   
                $('input[type="submit"]').prop('disabled', true);
                $('.file_error').html('<div class="alert alert-danger" role="alert"> <strong>Oh snap!</strong> '+msg+' </div>');
                $(document).scrollTop( $('.file_error').offset().top );
            }  else
            {
                $('.file_error').empty();
                $('input[type="submit"]').prop('disabled', false);
            }             
        });
           
  
          
		});	
	</script>
@endsection
