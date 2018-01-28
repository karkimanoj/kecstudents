@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-10  ">
        	<h2><center>Create New permission</center></h2>
            <hr>

             <form method="POST"  action="{{route('permissions.store')}} ">
                        {{csrf_field()}}

                        <!-- radio for selecting basic and crud  -->
                    <div class="form-check form-check-inline">
                        
                        <input type="radio" class="form-check-input" name="permission_type" value='basic' checked> 
                        <label class="form-check-label"> Basic permission</label>
                    
                        <input type="radio" class="form-check-input m-l-40" name="permission_type" value="crud"> 
                        <label class="form-check-label"> Crud permission </label>   
                    </div>    
                   
                   <!-- form fields for basic permission -->
                <div class="panel panel-default  m-t-30" id="basic_panel">
                    <div class="panel-body">
                        <div class="form-group {{ $errors->has('display_name')?'has-error':'' }}">
                            <label> Name (Display name) </label>
                            <input type="text" name="display_name" class="form-control" required minlength="5" maxlength="100">
                        </div>
                        <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
                            <label> slug </label>
                            <input type="text" name="name" class="form-control" required minlength="5" maxlength="100">
                        </div>
                        <div class="form-group {{ $errors->has('description')?'has-error':'' }}">
                            <label> Description </label>
                            <input type="text" name="description" class="form-control" required minlength="8" maxlength="150">
                        </div>
                        
                    </div>
                </div>  <!-- end of basic panel -->
 
                   <!-- form fields for crud permission -->
                <div class="panel panel-default m-t-30" id="crud_panel">
                    <div class="panel-heading">
                        <div class="form-group {{ $errors->has('resource')?'has-error':'' }}">
                            <label> Resource </label>
                            <input type="text" name="resource" class="form-control" required minlength="5" maxlength="80">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h4>select permissions</h4>
                                <div class="form-check m-t-10">
                                   <input class="form-check-input" type="checkbox"  value="create" name="crud_checks[]" checked>
                                   <label>create</label>
                                </div>
                                    
                                <div class="form-check m-t-10">
                                  <input class="form-check-input" type="checkbox"  name="crud_checks[]" value="read" checked>
                                  <label>read</label>
                                </div>
                                
                                <div class="form-check m-t-10">
                                  <input class="form-check-input" type="checkbox"  name="crud_checks[]" value="update" checked>
                                       <label>update</label>
                                </div>
                           
                                <div class="form-check m-t-20">
                                  <input class="form-check-input" type="checkbox"  name="crud_checks[]" value="destroy" checked>
                                  <label>destroy</label>
                                </div>
                            </div>
                             
                            <div class="col-md-6">
                                <h4>permission names</h4>
                                <ul class="list-group" id="permission_list">
                                  
                                </ul>
                            </div>
                        </div>    
                    </div> <!-- end of crud panel -->

                </div>   
                <center>
                          <input type="submit" class="btn btn-primary btn-lg" name="create" > 
                       </center>
             </form>    
                
        </div>
    </div>
</div>

@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){

            /*
               function for diplaying different fields according to permission type 
            */
            function permission_control(permission_type){
                if(permission_type=='basic')
                  { 
                    $('#crud_panel :input').prop('disabled', true);
                    $('#crud_panel').hide(300);
                    $('#basic_panel :input').prop('disabled', false);
                    $('#basic_panel').show(300);

                  } else {
                    $('#crud_panel').show(300);
                    $('#crud_panel :input').prop('disabled', false);
                    $('#basic_panel :input').prop('disabled', true);
                    $('#basic_panel').hide(300);
                  }     
            }

            permission_control($('input[name=permission_type]').val());

			$('input[name=permission_type]').on("click ", function(){
                 permission_control($(this).val());
                //alert(permission_type);
                
                      
				});	

             /*
              function for displaying permission names for the resource type
            */
            function display_permission_names(){
                resource_val=$('input[name=resource]').val();

                if(resource_val.length>=3)
                { 
                    $('#permission_list').html('');
                    
                    $.each($("input[name='crud_checks[]']:checked"), function() {
                        //alert($(this).val());
                       $('#permission_list').append('<li class="list-group-item">'+
                        $(this).val()+'-'+resource_val+'</li>');
                    });
                } else
                    $('#permission_list').html('');
            }

           
            $('input[name=resource]').keyup(function()
            {
                display_permission_names();
            });

            $("input[name='crud_checks[]']").change(function(){
                display_permission_names();
            });


			});	
	</script>
@endsection