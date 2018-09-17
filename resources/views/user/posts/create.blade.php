@extends('layouts.app')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>
     /* tinymce.init({ selector:'textarea',
              menubar:'false',
              plugins:'code link' });  */
  </script>

@endsection



@section('content')

<div class="main-container">

    <div class="row">
      <div class="col-md-12" id="top_header" >        
         <h2 class="text-center">Start A Discussion</h2>          
      </div>    
    </div>

    <div class="container">
  <form method="POST" action="{{route('user.posts.store')}} " enctype="multipart/form-data" id="post-form">
    <div class="row ">
        <div class="col-md-9  bg-white mb-3">

        	<div class="row">
                <div class="col-md-12 file_error mt-2" >
                    
                </div>
            </div>
        	 <div class="card card-default borderless mt-3 p-2">
                <div class="card-body">



                  
                    {{csrf_field()}}        

                    <div class="form-group {{ $errors->has('content')?'has-error':'' }} mt-2">
                        <label >Ask a question? * : </label>
                        <textarea required name="content"  class="form-control"  rows="10" maxlength="10000">{{old('content')}}</textarea>
                        @if($errors->has('content'))
                            <span class="help-block">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mt-3" >
                      <label >tags * :</label>
                      <select required class="form-control" id="tag_select" multiple="multiple" name="tags[]" > </select>
                      <small class="form-text text-muted">
                      select up to 20 tags. you can create your own tag by typing the tagname and hitting enter.
                      </small>
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
                      Accepted extensions are png, jpej, gif, jpg . Max image size is 5 MB
                      </small>
                    </div>

                    <!--<div class="form-group text-center">
                      <input type="submit" name="submit" value="submit" class="btn btn-primary btn-lg">
                    </div>-->
                    @if(Auth::user()->hasPermission('create-invites'))
                     <!-- Notify Modal -->
                    <div class="modal " id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="notifyModal" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="notifyModalTitle">Notify users</h5>
                            <!--display errors in notify fields-->
                            <span class="help-block text-danger">
                            @if($errors->has('start_rollno'))                                     <strong>{{ $errors->first('start_rollno') }}</strong>
                            @endif
                            @if($errors->has('end_rollno'))                                       <strong>{{ $errors->first('end_rollno') }}</strong>
                            @endif
                            @if($errors->has('ind_rollno'))                                       <strong>{{ $errors->first('ind_rollno') }}</strong>
                            @endif
                           </span>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox"  id="group_notify_checkbox" checked>
                                  <label class="form-check-label" for="group_notify_checkbox">
                                    Group
                                  </label>
                                </div>
                                <table class="table-no-bordered p-3" id="notify_table">
                              <thead >
                                <tr  >
                                  <th scope="col" width="40%">Roll No range</th>
                        
                                  
                                  <th scope="col">Faculty </th>
                                  <th scope="col">Year</th>
                                  <th scope="col"></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr >
                                  <th scope="row">
                                    <div class="row">
                                      <div class="col-sm-5 ">
                                        <input type="number" name="start_rollno[]" class="start_rollno form-control form-control-sm" min="1" max="400" required>
                                      </div>
                                      <div class="col-sm-1">
                                        ~
                                      </div>
                                      <div class="col-sm-5">
                                        <input type="number" name="end_rollno[]" class="end_rollno form-control form-control-sm" min="1" max="400" required>
                                      </div>
                                    </div>
                                  </th>
                                  <td><select class="form-control form-control-sm" name="faculty[]" required>
                                    <option value="All">All</option>
                                    @foreach(App\Faculty::all() as  $faculty)
                                    <option value="{{$faculty->id}}">{{$faculty->name}}</option>
                                   @endforeach
                                  </select></td>
                                  <td>
                                    <select class="form-control form-control-sm" name="year[]" required>
                                      @for($i=2065; $i<=2090; $i++) 
                                        <option value="{{$i}}" @if($i==2071) {{'selected'}} @endif>{{$i}}</option>
                                      @endfor
                                  </select>
                                  </td>
                                  <td>
                                    <input type="button" class="btn btn-sm ml-2" id="add_row_notify" value="+">
                                  </td>
                                </tr>
                              </tbody>
                            </table>

                            <div class="form-group mt-3" >
                             <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="individual" id="individual_notify_checkbox">
                                <label class="form-check-label" for="individual_notify_checkbox">
                                  Individual
                                </label>
                              </div>
                              <select class="form-control mt-2" id="notify_select" multiple="multiple" name="ind_rollno[]"  style="width: 100%;" disabled> </select>
                              <small class="form-text text-muted">
                              HINT: Type user roll no and press Space , Comma or Enter Key. Max no of user is 40. use group notification for large group of users.
                              </small>
                            </div>

                             
                          </div>
                          <div class="modal-footer">
                            <input type="submit" class="btn btn-secondary" name="submit" value="Dont Notify"> 
                            <input type="submit" class="btn btn-primary" name="submit" value="Yes"> 
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end of Notify Modal -->
                    @endif

                   


                </div>
            </div>

        </div>
  

	    <div class="col-md-3 mt-3 mb-3">
            <div class="card  card_shadow w-100 borderless" id="user_widget">

                <div class="card-header  " style="background-color: #F39C12">
                  <div id="card_img">
                    <img class="card-img img-circle bg-primary" src="/images/test-image.jpg" alt="Card image cap">
                  </div>
                  <div class="card_user_detail">
                     <span style="font-size: 1.2em">{{Auth::user()->name}}</span><br>
                       <span >{{Auth::user()->roles->first()->name}}</span><br>
                       <span >{{Auth::user()->roll_no}}</span><br>
                  </div>
               
                </div>             
                <div class="card-body ">
                   <ul class="nav flex-column text-center text-muted">
                      <li class="nav-item">
                        <span class="badge badge-light">{{Auth::user()->projects->count()}}</span><br>
                        <a class="nav-link" href="{{route('user.projects.index')}}">Projects </a>
                      </li>
                      <li class="nav-item">
                         <span class=" badge badge-light">{{Auth::user()->event1s()->count()}}</span><br>
                        <a class="nav-link" href="{{route('user.events.index')}}">Events</a>
                      </li>
                      <li class="nav-item">
                        <span class=" badge badge-light">{{Auth::user()->downloads->count()}}</span><br>
                        <a class="nav-link" href="{{route('user.downloads.index')}}">Downloads </a>
                      </li>
                      
                      <li class="nav-item">
                        <span class="badge ">{{Auth::user()->posts->count()}}</span><br>
                        <a class="nav-link active" href="{{route('user.posts.index')}}"><h7>posts<h7> </a>
                      </li>
                    </ul> 
                </div>
                
                <div class="card-footer bg-white borderless">
	                <div class="row">
	                    <div class="col-md-6">
                      @if(Auth::user()->hasPermission('create-invites'))
                        <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#notifyModal"> submit </button>
                      @else
                        <input type="submit"  name="submit" class="btn btn-primary btn-sm btn-block"  value="submit_" >
                      @endif

                        
	                    </div>
	                    <div class="col-md-6">
	                      <button class="btn btn-outline-primary btn-sm btn-block">reset</button>
	                    </div>
	                </div>
                </div>
            </div>

            <div class="card w-100 mt-3 borderless" >
                <div class="card-body">                       
                 <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">upload new project</a>
                  <a href="{{route('user.downloads.create')}}" class=" btn btn-outline-primary btn-block ">upload new materials</a>
                  
                   <a href="{{route('user.posts.create')}}" class=" btn btn-outline-primary btn-block ">create new post</a>
                </div>
            </div>

        </div>
        <!-- end of right container with profile cards -->

    </div>	
    </form> 
</div>
</div>
@endsection





@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function(){

        $('#add_row_notify').on('click', function(){
          if($('tbody tr').length < 12)
          {
            cloned_row=$('tbody tr').first().clone()
            //console.log($('thead tr:first'))
            cloned_row.find('#add_row_notify').replaceWith( ' <input type="button" class="close_btn btn btn-sm ml-2 "  value="-">')
            cloned_row.appendTo('tbody');
          }
        });

        $('#post-form').on('click', '.close_btn' ,function(){
          $(this).parents('tr').remove() 
     
        })
        $('#individual_notify_checkbox').on('change', function(){
          if($(this).prop('checked')==true) 
            $('#notify_select').attr('disabled', false)
          else 
             $('#notify_select').attr('disabled', true)

        })
        $('#group_notify_checkbox').on('change', function(){
          if($(this).prop('checked')==true) 
            $('#notify_table input, #notify_table select').attr('disabled', false)
          else 
             $('#notify_table input, #notify_table select').attr('disabled', true)

        })

        var permission_flag = '{{Auth::user()->hasPermission('create-invites')}}';
       /* $('#notify_trigger').on('click', function(){

          
            //alert($('#post-form')[0].checkValidity());
            $('#notifyModal').modal('show')
        });

       $('#post-form').submit(function(){
          alert('yes')
          return true;
        });*/

        /*
        $('#post-form').submit(function(){
          flag = 1;
          for(i=0; i<$('.start_rollno').length; i++)
           {
            start_rollno = $('.start_rollno')
            end_rollno = $('.end_rollno')
            //alert($(start[i]).val())
                if( (($(start_rollno[i]).val()==  && $(end_rollno[i]).val() ) || 
                 ($(start_rollno[i]).val()==null && $(end_rollno[i]).val()==null))==false  )
                alert('no'); else 
                alert($(start_rollno[i]).val()+$(end_rollno[i]).val());
          };

         // if(flag == 1)
           //alert('yes'); else alert('no');
            return false;
     
        })*/
         //select 2 notify part  
          /*
        $('#post-form').submit(function(){
          alert('yes');
          return false;
        });*/

         
        $('#notify_select').select2({
             placeholder: "EG: 044BCT2071",
            maximumSelectionLength:40,
            tags:true,
            tokenSeparators: [',',' '],
            createTag: function(param){
                 term=(param.term).trim();
                length=term.length;

                fchar=term.charAt(0);
                lchar=term.charAt(length-1);

                if(length<10 || term.indexOf(',')!== -1 || term.indexOf('\'')!== -1 || term.indexOf('\"')!== -1 || fchar==',' || fchar=='-' || fchar=='_' || lchar=='_'|| lchar=='-' || term.indexOf('@')!== -1)
                    return null;
                else
                    return {
                      id: term,
                      text: term,
                      newTag: true 
                    }
            }
        }); //end of select 2
        
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
                 term=(param.term).trim();
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