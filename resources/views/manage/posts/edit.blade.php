@extends('layouts.manage')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
      tinymce.init({ selector:'textarea',
              menubar:'false',
              plugins:'code link' });
  </script>

@endsection
@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-10 offset-md-1 ">
        	<h2><center>Edit Post</center></h2>

              <div class="card card-default borderless mt-3 p-2">
                <div class="card-body">



                  <form method="POST" action="{{route('posts.update', $post->slug)}} " enctype="multipart/form-data" id="post-form">
                    {{csrf_field()}}   
                    {{method_field('PUT')}}
                    <div class="form-group {{ $errors->has('content')?'has-error':'' }} mt-2">
                        <label >Ask a question? * : </label>
                        <textarea name="content" class="form-control" required rows="10" maxlength="10000">
                        {{ $post->content }}  </textarea>
                        @if($errors->has('content'))
                            <span class="help-block">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mt-3" >
                      <label >tags * :</label>
                      <select class="form-control" id="tag_select" multiple="multiple" name="tags[]" required> </select>
                      <small class="form-text text-muted">
                      select up to 20 tags. you can create your own tag by typing the tagname and hitting enter.
                      </small>
                    </div>

                    <div class="row">
                      <div class="col">
                         <img src="{{asset($post->imgs()->first()->filepath)}}"  width="40%" class="img-fluid" alt="Responsive image">
                        <small class="form-text text-muted">
                       select new image to replace this existing image otherwise leave image field empty.
                      </small>
                      </div>
                    </div>

                    <div class="form-group {{ $errors->has('image')?'has-error':'' }} mt-2">
                        <label >Image <span class="text-muted">(optional) </span> : </label>
                        <input type="file" name="image"  class="form-control" accept="image/*" id="post_image" value="{{old('image')}}">
                          
                        @if($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                        <small class="form-text text-muted">
                       .Accepted extensions are png, jpej, gif, jpg . Max image size is 5 MB
                      </small>
                    </div>

                    <div class="form-group text-center">
                      <input type="submit" name="submit" value="Update" class="btn btn-primary btn-lg">
                    </div>
                    

                  </form>  


                </div>
            </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function(){
       //select 2 tag[] part  start 
        var data = [@foreach($tags as $tag)
            {
                id: {{$tag->id}},
                text: '{{$tag->name}}'
            },

            @endforeach];
        $('#tag_select').select2({
            data:data,
            maximumSelectionLength:20,
            tags:true,
            tokenSeparators: [',',' '],
            createTag: function(param){
                var term=(param.term).trim();
                length=term.length;

                fchar=term.charAt(0);
                lchar=term.charAt(length-1);

                if(length<2 || term.indexOf(',')!== -1 || term.indexOf('\'')!== -1 || term.indexOf('\"')!== -1 || fchar==',' || fchar=='-' || fchar=='_' || lchar=='_'|| lchar=='-' || term.indexOf('@')!== -1)
                    return null;
                else
                    return {
                      id: '@'+term,
                      text: term,
                      newTag: true 
                    }
            }
        }); //end of select 2

         $selected_tags=[ @foreach($post->tags as $selected_tag)
                  {{$selected_tag->id}},
                 @endforeach
        ];
        $('#tag_select').val($selected_tags);

        $('#post_image').change(function(){

            accepted_exts=['png', 'jpeg', 'jpg', 'gif'];
           // alert(accepted_exts)
            element=document.getElementById('post_image');
            $('.file_error').empty();
            flag=true;
     
            if($('#post_image').val())
            {  
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