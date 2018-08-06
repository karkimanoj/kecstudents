@extends('layouts.app')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>/*
      tinymce.init({ selector:'textarea',
              menubar:'false',
              plugins:'code link' });*/
  </script>

@endsection

@section('content')

<div class="main-container">

    <div class="row">
      <div class="col-md-12" id="top_header" >        
         <h2 class="text-center">New Upload</h2>          
      </div>    
    </div>

    <div class="container">

    <div class="row ">
        <div class="col-md-9  bg-white mb-3">

        	<div class="row">
                <div class="col-md-12 file_error" >
                    
                </div>
            </div>
        	<div class="panel panel-default mt-3">
                <div class="panel-body">



                    <form method="POST" action="{{route('user.downloads.store')}} " enctype="multipart/form-data" id="uploadForm">
                                {{csrf_field()}}    
                                  
                                <div class="row form-group mt-3{{ $errors->has('title')?'has-error':'' }} ">
                                     
                                     <div class="col-md-10  offset-md-1 form-group">
                                     	<label >Title:</label>
                                         <input type="text" name="title" minlength="4" class="form-control" value="{{old('title')}}" required maxlength="191">
                                         <small class="form-text text-muted">
                                          Eg's: Cprogramming note by suresh prajapathi, BCT 1 syllabus
                                        </small>
                                        @if($errors->has('title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif

                                     </div>                 
                                </div>
                                        
                                <div class=" row form-group mt-3">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">Category</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" id="category_select" name="category">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}"> {{$category->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class=" row form-group  mt-4">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">Faculty/Semester</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control m-r-20" id="faculty_select" name="faculty">
                                            @foreach($faculties as $faculty)
                                                <option value="{{$faculty->id}}"> {{$faculty->name}} </option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                    <div class="col-md-4 ">
                                        <select class="form-control m-r-20" id="semester_select" name="semester">
                                            <option value="1">First</option>
                                            <option value="2">Second</option>
                                            
                                            <option value="3">Third</option>
                                            <option value="4">Fourth</option>
                                            <option value="5">Fifth</option>
                                            <option value="6">Sixth</option>
                                            <option value="7">Seventh</option>
                                            <option value="8">Eighth</option>
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class=" row form-group mt-4" id="subject_div">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">Choose Subjects</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" id="subject_select" name="subject">
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group mt-4 {{ $errors->has('description')?'has-error':'' }} ">
                                    <div class="col-md-10  offset-md-1 form-group">
                                     	<label >Description:</label>
                                         <textarea class="form-control" required rows="10" name="description" ></textarea>
                                        @if($errors->has('description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                     </div>                 
                                </div>

                                <div class=" row form-group mt-3 {{ $errors->has('files1')  ?'has-error':'' }}">
                                    <div class="col-md-10  offset-md-1 form-group">
                                     	
                                        <input type="file" id="upload_file" name="files1[][file]" multiple="false" class="form-control"    >
                                        @if($errors->has('files1') )
                                            <strong>{{ $errors->first('files1') }}</strong>
                                        @else
                                        <small class="form-text text-muted">
                                        Maximum 12 files for 'Note' and 1 file for other categories.
                                        </small>
                                        @endif
                                    </div>
                                </div>

                                <div class=" row form-group mt-3">
                                    <div class="col-md-12 ">               
                                       <table class="table invisible" id="file-table">
                                          <thead>
                                            <tr>
                                              <th scope="col">#</th>
                                              <th scope="col">Filename/s</th>
                                              <th scope="col">Display Name</th>
                                            </tr>
                                          </thead>
                                          <tbody class="pr_display_names">
                                            
                                          </tbody>
                                        </table>
                                         <small class="form-text text-muted">
                                            Eg: For notes with multiple file, use chapter no: chapter name. For other categories with only1 file , either use title name or create own display name.
                                        </small>
                                    </div>
                                    
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

                         
                                
                        </form>  


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
                        <!--
                        <button class="btn btn-primary btn-sm btn-block" onclick="document.getElementById('uploadForm').submit();" >upload </button>-->
	                      <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#notifyModal"> Upload </button>
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
                  <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">upload new note</a>
                  <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">create new event</a>
                   <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">create new post</a>
                </div>
            </div>

        </div>
        <!-- end of right container with profile cards -->

    </div>	
</div>
</div>
@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

           var subjects_json=@json($facs);
           var all_subjects=JSON.parse(subjects_json);
           var categories= @json($categories);

           //Notify users js start
           $('#add_row_notify').on('click', function(){
              if($('tbody tr').length < 12)
              {
                cloned_row=$('tbody tr').first().clone()
                //console.log($('thead tr:first'))
                cloned_row.find('#add_row_notify').replaceWith( ' <input type="button" class="close_btn btn btn-sm ml-2 "  value="-">')
                cloned_row.appendTo('tbody');
              }
            });

            $('#notifyModal').on('click', '.close_btn' ,function(){
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
            }); 
            //Notify users end

            /*
                function to show subject according to faculty/semester
            */
            function subjects()
            {
                fac=$('#faculty_select').val();
                sem=$('#semester_select').val();

                    $('#subject_select').html('');
                for(x in all_subjects[fac][sem])
                {       
                    $('#subject_select').append('<option value='+x+'>'+all_subjects[fac][sem][x]+'</option>');
                    
                 }
            }

             subjects();   

           $(document).on('change','#faculty_select, #semester_select', function(){
                subjects();
           });

          {{--
           var category_type={
                    @foreach($categories as $category)
                       '{{$category->id}}':'{{$category->category_type}}',
                    @endforeach
           };
           --}}
           
           
           /*
            function subject_disable()
            {
                category_id=$("#category_select").val();
                
                 if(category_type[category_id].trim()=='facsem')
                 {     
                    $('#subject_select').prop('disabled', true);
                    

                 }  else
                 {
                   
                    $('#subject_select').prop('disabled', false);
                 }   
            }*/
            function subject_disable()
            {
                category_id=$("#category_select").val();
                 
                 for ( k = 0; k < categories.length; k++) 
                 {  
                    if(categories[k].id == category_id) 
                    {  
                      if( categories[k].category_type =='facsem')
                      
                        $('#subject_select').attr('disabled', true); 
                      else
                        $('#subject_select').attr('disabled', false);
                    }  
                  }
            }

              subject_disable()

            $('#category_select').change(function(){
                 
                subject_disable();
                multiple_file();
            });

            multiple_file();

            var accepted_exts;
            
        function multiple_file()
        {
           
           selected_category=$("#category_select option:selected").text().trim();

           if(selected_category=='note'){
                $('input[type="file"]').attr('multiple', true);
                accepted_exts=['pdf','doc', 'docx', 'dotx', 'ppt', 'ppsx', 'pptm', 'pptx'];  
                
           }
           else{
               $('input[type="file"]').attr('multiple', false);
               accepted_exts=['pdf','doc', 'docx', 'dotx'];
           }

        }

        $('#upload_file, #category_select').on('change', function(){
            
            element=document.getElementById('upload_file');
            
            if(element.files.length > 0) $('#file-table').removeClass('invisible')
              else  $('#file-table').addClass('invisible')

            $('.pr_display_names').empty();
            flag=true;

            category_id=$("#category_select").val();
            file_limit = 1;
            for ( k = 0; k < categories.length; k++) 
            {  
              if(categories[k].id == category_id)  
                file_limit=categories[k].max_no_of_files
              
            }

            if(element.files.length <= file_limit)
            {   
                totalSize=0;
                for ( i = 0; i < element.files.length; i++) 
                {   
                    file=element.files[i];
                    filename=file.name;
                    totalSize=totalSize + file.size;

                    if(file.size > 0)
                    {   
                        ext=filename.split('.')[filename.split('.').length-1].toLowerCase();

                        if(accepted_exts.indexOf(ext) == -1)
                        {
                            flag=false; 
                            msg=filename+' extension is invalid. use approprite file'; 
                            break;
                        } else
                        $('.pr_display_names').append(' <tr> <td>'+ (i+1) +'</td> <td>'+filename+'                        </td>    <td>  <input type="text" name="files1['+i+'][dname]" required class="form-control" placeholder="chapter no: chapter name" minlength="3" maxlength="191"></td></tr> ');
                    }else
                    {   break;
                        flag=false; 
                        msg=filename+'is empty ,i.e, filesize = 0'; 
                    }
                }
                if(totalSize>52428800)
                {
                    flag=false; 
                    msg=filename+' total filesize exceeded 50 MB';
                }
            } 
            else
            {
              flag=false; 
              msg='No of files exceeded the limit .';     
            }
                     
            if(flag == false)
            {   $('input[type="submit"]').prop('disabled', true);
                $('.file_error').html('<div class="alert alert-danger" role="alert"> <strong>Oh snap!</strong> '+msg+' </div>');
                $(document).scrollTop( $('.file_error').offset().top );
            }  else
            {
                $('.file_error').empty();
                $('input[type="submit"]').prop('disabled', false);
            }             
        });
           
         //alert(accepted_exts);
         /*
        $( "#form" ).submit(function( event )
         {
           element=document.getElementById('upload_file');
           if(element.files.length <= 12)
           {
               for ( i = 0; i < element.files.length; i++) 
                {
                    file=element.files[i];
                    $('.file_error').empty();
                    if(file.size > 0)
                    {
                        filename=file.name;
                        ext=filename.split('.')[filename.split('.').length-1].toLowerCase();
                        
                        if(accepted_exts.indexOf(ext) == -1)
                        {
                            $('.file_error').html(' <div class="alert alert-danger" role="alert"> <strong>Oh snap!</strong> file extension is invalid. use approprite file. </div>');
                             $(document).scrollTop( $('.file_error').offset().top );
                            return false;
                        } else
                        {
                            return true;
                        }
                        

                    }
                    else{
                        $('.file_error').html('<div class="alert alert-danger" role="alert"> <strong>Oh snap!</strong>No file selected. select correct file format </div>');
                        $(document).scrollTop( $('.file_error').offset().top );
                        return false;
                    }
               
                }
            } else{
                    $('.file_error').html('<div class="alert alert-danger" role="alert"> <strong>Oh snap!</strong> No of files exceeds the limit of 12 files. </div>');
                    $(document).scrollTop( $('.file_error').offset().top );
                        return false;
                    }    

        });*/
          
		});	
	</script>
@endsection
