@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-10 offset-md-1 ">
        	<h2><center>Create New Faculty</center></h2>
            <div class="alert alert-secondary " role="alert">
                <ul>
                    <li>Multiple file select (ctrl + select max 10 files) is available only for 'note' . 
               </li>                   
                    <li>File format for note is .pdf, .docx and .ppt </li>
                    <li>File format for other categories is .pdf and .docx</li>
                </ul>
                
            </div>
            <div class="row">
                <div class="col-md-12 file_error" >
                    
                </div>
            </div>
           
              <div class="panel panel-default mt-2">
                    <div class="panel-body">
                        <form method="POST" action="{{route('downloads.store')}} " enctype="multipart/form-data" id="form">
                                {{csrf_field()}}    
                                  
                                <div class="row form-group m-t-20{{ $errors->has('title')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">Title:</label>
                                    </div>    
                                     <div class="col-md-8">
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
                                        
                                <div class=" row form-group m-t-10">
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

                                <div class=" row form-group m-t-20" id="subject_div">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">Choose Subjects</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" id="subject_select" name="subject" >
                                            
                                        </select>
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

                                <div class=" row form-group m-t-20 {{ $errors->has('files1')  ?'has-error':'' }}">
                                    <div class="col-md-3 mr-3" >               
                                       <label class="float-right mr-3" >File/s
                                       </label>
                                    </div>
                                    <div class="col-md-8" >
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
                                       <table class="table">
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

                               
                                        <center><input type="submit" name="upload" value="upload" class="btn btn-primary"></center>
                                
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

           var subjects_json=@json($facs);
           var all_subjects=JSON.parse(subjects_json);
           var categories= @json($categories);
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

           /*var category_type={
                    @foreach($categories as $category)
                       '{{$category->id}}':'{{$category->category_type}}',
                    @endforeach
           };*/
           
           
          

         // console.log(categories);

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

        $('#upload_file').change(function(){
            
            element=document.getElementById('upload_file');
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
              msg='No of files exceeded the limit of 12 files.';     
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
