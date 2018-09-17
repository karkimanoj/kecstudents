@extends('layouts.app')

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

    <div class="row">
      <div class="col-md-12" id="top_header" >        
         <h2 class="text-center">Edit Upload</h2>          
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


                <form method="POST" id="updateForm" enctype="multipart/form-data" action="{{route('user.downloads.update', $download->id)}} ">
                                {{method_field('PUT')}}
                                {{csrf_field()}}    
                                
                                <div class="row form-group m-t-20{{ $errors->has('title')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">Title:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <input type="text" name="title" minlength="4" class="form-control" value="{{$download->title or old('title')}}" required maxlength="191">
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

                                <div class=" row form-group m-t-10">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">Category</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{$download->download_category->name}}
                                    </div>
                                </div>

                                <!--start faculty/semesyer subject selection -->
                              

                                 <div class=" row form-group  m-t-20">
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

                                @if($download->download_category->category_type == 'subject')   
                                 <div class=" row form-group m-t-20" id="subject_div">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">Choose Subjects</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" id="subject_select" name="subject">
                                            
                                        </select>
                                    </div>
                                 </div>
                                @endif
                            <!--end faculty/semesyer subject selection -->
                                
                                <div class="row form-group m-t-20{{ $errors->has('description')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">Description:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <textarea class="form-control" required rows="10" name="description">{{$download->description }}</textarea>
                                        @if($errors->has('description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                     </div>                 
                                </div>

                              @if($download->download_category->name == 'note')      
                                <div class=" row form-group m-t-20">
                                     <div class="col-md-12 ">          
                                        <table class="table table-responsive">
                                          <thead>
                                            <tr>
                                              <th scope="col" class="text-danger">Delete</th> 
                                              <th scope="col"> Name </th> 
                                              <th scope="col"> Filepath </th>
                                           </tr>
                                          </thead>
                                          <tbody>
                                            @foreach($download->download_files as $file)
                                            <tr>
                                              <td>
                                                  <div class="form-check">
                                                    <input class="form-check-input position-static" type="checkbox" name="delDownload[]" value="{{ $file->filepath}}" aria-label="delete file">
                                                  </div>      
                                                  <input type="hidden" name="delete[]" value="">
                                               </td>
                                               <td scope="row"><small>{{ $file->display_name}}</small></td>
                                               <td scope="row"><small>{{ $file->filepath}}</small></td>
                                            </tr>
                                            @endforeach     
                                          </tbody>
                                        </table>              
                                    </div>
                                </div>
                                
                                <div class=" row form-group m-t-20 {{ $errors->has('files1')  ?'has-error':'' }}">
                                    <div class="col-md-3 mr-3" >               
                                       <label class="float-right mr-3" >Add New File/s
                                       </label>
                                    </div>
                                    <div class="col-md-8" >
                                        <input type="file" id="upload_file" name="files1[][file]" {{ ($download->download_category->name == 'note') ? 'multiple' : '' }} class="form-control"    >
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
                                       <table class="table ">
                                          <thead>
                                            <tr>
                                              <th scope="col">#</th>
                                              <th scope="col">File Name/s</th>
                                              <th scope="col">Display Name</th>
                                            </tr>
                                          </thead>
                                          <tbody class="pr_display_names">
                                            
                                          </tbody>
                                        </table>
                                         <small class="form-text text-muted">
                                            Eg: For notes with multiple file, use chapter no: chapter name. For other categories with only 1 file , either use title name or create own display name.
                                        </small>
                                    </div>
                                    
                                </div>       
                                @else 

                                  <div class=" row form-group m-t-10">
                                    <div class="col-md-3">               
                                       <label class="right mr-3">File</label>
                                    </div>
                                    <div class="col-md-8">
                                        @foreach($download->download_files as $file)
                                             {{$file->filepath}}
                                        @endforeach
                                    </div>
                                </div>  
                               @endif

                                
                                
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
                        <button class="btn btn-primary btn-sm btn-block" onclick="document.getElementById('updateForm').submit();" >update </button>
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
</div>
</div>
@endsection  

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
        
                //alert($('input[name="delDownload"]').val());

            
           var subjects_json=@json($facs);
           var all_subjects=JSON.parse(subjects_json);

           var category_type='{{ $download->download_category->category_type }}';

            var fac='{{ ($download->subject_id) ? $download->subject->faculties->first()->id : $download->faculty_id }}';
            
            var sem='{{ ($download->subject_id) ? $download->subject->faculties->first()->pivot->semester : $download->semester }}';

            var subject='{{ $download->subject_id }}';

            $('#faculty_select').val(fac);
             $('#semester_select').val(sem);
                 
           if(category_type=='subject')
           {
             
             $(document).on('change','#faculty_select, #semester_select', function(){
                subjects();
             });
             
             subjects();

             function subjects()
             {
                fac=$('#faculty_select').val();
                sem=$('#semester_select').val();

                    $('#subject_select').empty();
                for(x in all_subjects[fac][sem])
                {       
                    $('#subject_select').append('<option value='+x+'>'+all_subjects[fac][sem][x]+'</option>');
                    
                 }
             }

             if(subject) $('#subject_select').val(subject);
           } 

          
         var category='{{$download->download_category->name}}';

        if(category=='note')
        {    
           file_no_limit={{ $download->download_category->max_no_of_files}}-{{$download->download_files->count()}}; 
            accepted_exts=['pdf','doc', 'docx', 'dotx', 'ppt', 'ppsx', 'pptm', 'pptx']; 

           $('#upload_file').change(function(){
            
            element=document.getElementById('upload_file');
            $('.pr_display_names').empty();
            flag=true; 
            if(element.files.length <= file_no_limit)
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
              msg='No of files exceeded the limit of '+file_no_limit+' files.';     
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
    }    
        /*
           var category='{{--$download->download_category->name--}}'
             
            if(category=='note')
            {    
             accepted_exts=['pdf','doc', 'docx', 'dotx', 'ppt', 'ppsx', 'pptm', 'pptx']; 

                $( "#form" ).submit(function( event )
                 {
                   element=document.getElementById('upload_file');
                   //alert(element.files.length)
                   for ( i = 0; i < element.files.length; i++) 
                    {
                        file=element.files[i];

                        $('.file_error').empty();
                        if(file.size > 0)
                        {
                            filename=file.name;
                            ext=filename.split('.')[filename.split('.').length-1].toLowerCase();
                            //alert(accepted_exts.indexOf(ext))
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

                });
            }*/
          
        }); 
    </script>
@endsection