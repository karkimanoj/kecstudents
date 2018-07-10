
@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-10 offset-md-1 ">
        	<h2><center>Edit Upload</center></h2>

            <div class="row">
                <div class="col-md-12 file_error" >
                    
                </div>
            </div>
            
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" id="form" enctype="multipart/form-data" action="{{route('downloads.update', $download->id)}} ">
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
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th scope="col" class="text-danger">Delete</th> <th scope="col"> Name </th> 
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
                                               <td scope="row">{{ $file->display_name}}</td>
                                               <td scope="row">{{ $file->filepath}}</td>
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
                                       <table class="table">
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

                                 <center><input type="submit" name="update" value="update" class="btn btn-primary"></center>
                                
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
            //alert(file_no_limit)
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