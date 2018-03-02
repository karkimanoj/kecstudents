@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-10 offset-md-1 ">
        	<h2><center>Create New Faculty</center></h2>
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" action="{{route('downloads.store')}} " enctype="multipart/form-data">
                                {{csrf_field()}}    
                                        
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
                                       <label class="right m-r-20">faculty/semester</label>
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
                                            <option value="1">first</option>
                                            <option value="2">second</option>
                                            
                                            <option value="3">third</option>
                                            <option value="4">fourth</option>
                                            <option value="5">fifth</option>
                                            <option value="6">sixth</option>
                                            <option value="7">seventh</option>
                                            <option value="8">eighth</option>
                                        </select>
                                        
                                    </div>
                                </div>

                                <div class=" row form-group m-t-20" id="subject_div">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">choose subjects</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" id="subject_select" name="subject">
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group m-t-20{{ $errors->has('description')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">description:</label>
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

                                <div class=" row form-group m-t-20">
                                    <div class="col-md-3 m-r-20">               
                                       <label class="right m-r-20">file</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" name="file1" class="form-control" required>
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

           var category_type={
                    @foreach($categories as $category)
                       '{{$category->id}}':'{{$category->category_type}}',
                    @endforeach
           };
           
           
           
            function subject_disable(){

                 var category_id=$("#category_select").val();
                 //alert(category);
                 //console.log(String(category));
                 if(category_type[category_id].trim()=='facsem')
                 {      //alert(category);
                    $('#subject_select').prop('disabled', true);
                    $('#subject_div').hide();

                 }  else
                 {
                    $('#subject_div').show();
                    $('#subject_select').prop('disabled', false);
                 }   
            }

              subject_disable()
            $('#category_select').change(function(){
                 
                subject_disable()
            });
           
        
           

          /* for(x in subjects_sem_fac)
           {
                for(y in subjects_sem_fac[x])
               {
                    for(z in subjects_sem_fac[x][y])
                   {
                    $('textarea').append(subjects_sem_fac[x][y][z]);
                   }
               }
           }*/
               
             

        
            /*
			function check_checkbox(){
					if($("#checkbox_auto_password").prop("checked"))
					   
					   $('#manage_password').prop('disabled', true);
				    else 
					  $('#manage_password').prop('disabled', false);
			}

			$('#checkbox_auto_password').click( function(){
				check_checkbox();
				});	
    */
			});	
	</script>
@endsection
