@extends('layouts.manage')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="main-container">
    

    <div class="row ">
        <div class="col-md-10 offset-md-1 ">
        	<h2><center>Start A Discussion</center></h2>

              <div class="card card-default  mt-3 p-2">
                <div class="card-body">



                  <form method="POST" action="{{route('posts.store')}} " enctype="multipart/form-data" id="post-form">
                    {{csrf_field()}}   

                    <div class="form-group {{ $errors->has('content')?'has-error':'' }} mt-2">
                        <label >Ask a question? * : </label>
                        <textarea name="content" class="form-control" required rows="10" maxlength="10000">
                        {{ old('content') }}  </textarea>
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
                    
                     <!-- Notify Modal -->
                    <div class="modal " id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                  <td><select class="form-control form-control-sm" name="facultyn[]" required="">
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
                    <div class="form-group text-center">
                      <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#notifyModal"> Submit </button>
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

        $('#add_row_notify').on('click', function(){
          if($('tbody tr').length < 12)
          {
            cloned_row=$('tbody tr').first().clone()
            //console.log($('thead tr:first'))
            cloned_row.find('#add_row_notify').replaceWith( ' <input type="button" class="close_btn btn btn-sm ml-2 "  value="-">')
            cloned_row.appendTo('tbody');
          }
        });

        $('tbody').on('click', '.close_btn' ,function(){
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