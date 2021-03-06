@extends('layouts.manage')
      

      
@section('content')
                                             
<div class="main-container">
    

    <div class="row ">
        <div class="col-md-10 offset-md-1 ">
        	<h2><center>Create A Notice</center></h2>

          <div class="row">
                <div class="col-md-12 file_error mt-2" >
                    
                </div>
            </div>

            <div class="card card-default  mt-3 p-2">
                <div class="card-body">

                  <form method="POST" action="{{route('notices.store')}}" enctype="multipart/form-data" id="notice-form">
                    {{csrf_field()}}   

                    <div class="form-group  mt-2  {{ $errors->has('title')?'has-error':'' }}">
                        <label >Title * : </label>
                        <input type="text" name="title" maxlength="255" class="form-control" value="{{ old('title') }}" required>
                        @if($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('content')?'has-error':'' }} mt-2">
                        <label >Content * : </label>
                        <textarea name="content" class="form-control" required rows="10" maxlength="10000">
                        {{ old('content') }}  </textarea>
                        @if($errors->has('content'))
                            <span class="help-block">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('image')?'has-error':'' }} mt-2">
                        <label >Image <span class="text-muted">(optional) </span> : </label>
                         <input type="file" name="images[]" multiple class="form-control" accept="image/*"  id="notice_image" >
                          
                        @if($errors->has('images'))
                            <span class="help-block">
                                <strong>{{ $errors->first('images') }}</strong>
                            </span>
                        @endif
                        <small class="form-text text-muted">
                        Max no of images to select is 5. Accepted extensions are png, jpej, gif, jpg . Max image size is 5 MB
                      </small>
                    </div>

                    <div class="form-group text-center">
                      <input type="submit" name="submit" id="submit_btn" value="submit" class="btn btn-primary btn-block">
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

    $('#notice_image').change(function(){

            accepted_exts=['png', 'jpeg', 'jpg', 'gif'];
           // alert(accepted_exts)
            element=document.getElementById('notice_image');
            $('.file_error').empty();
            flag=true;
     
            if($('#notice_image').val())
            { 
              if(element.files.length <= 4)
              {  
                for(i=0; i<element.files.length; i++) 
                {
                  image=element.files[i];
                  imagename=image.name;
                  size=image.size;
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
                    
                  if(size > 5242880) //5242880
                  {
                      flag=false; 
                      msg+=imagename+' total filesize exceeded 5 MB<br>';
                  }
                }
              }else
                {
                  flag=false; 
                  msg='No of files exceeded the limit .';     
                }
            }
            
           
                     
            if(flag == false)
            {   
                $('#submit_btn').prop('disabled', true);
                $('.file_error').html('<div class="alert alert-danger" role="alert"> <strong>Oh snap!</strong> '+msg+' </div>');
                $(document).scrollTop( $('.file_error').offset().top );
            }  else
            {
                $('.file_error').empty();
                $('#submit_btn').prop('disabled', false);
            }             
        });

  });

</script>

@endsection

  


