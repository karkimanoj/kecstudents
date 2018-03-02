



@extends('layouts.manage')
{{--
@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
--}}

@section('content')
	<div class="main-container">

		<div class="row m-b-20">
			<div class="col-md-6">
				<div class="page-header">
				  <h1>Edit subject</h1>
				</div>
			</div>			
			<div class="col-md-4 offset-md-2 ">
				<a href="{{ route('subjects.index') }}" class="btn  btn-primary float-right"> delete this subject</a>
			</div>
		</div>

		<form method="POST"  action="{{route('subjects.update', $subject->id)}} ">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
			<div class="row">
				<div class="col-md-10">
					<div class="panel panel-default m-l-5">
						  <div class="panel-heading">
						    <h3>subject details:</h3>
						  </div>
						  <div class="panel-body">
						    
		                        <div class="form-group {{ $errors->has('name')?'has-error':'' }}">
		                            <label class="col-form-label"> Name </label>
		                            
		                            <input type="text" name="name" class="form-control"    maxlength="255" required value="{{$subject->name}}">
		                            @if($errors->has('name'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('name') }}</strong>
	                                    </span>
	                                @endif
	                                
		                        </div>
		                        <div class="form-group m-t-20">
		                        	<label class="col-form-label"> faculty</label>
		                            <div >
			                            @foreach($faculties as $faculty)
										  <div class="form-row">
											  <div class="form-group col-md-6">
											  	
											      <input type="checkbox" name="faculty[]" value="{{$faculty->id}}">
												  	{{$faculty->name}}
												  	<i class="text-muted" >({{$faculty->display_name}})</i>
												  	@if($errors->has('faculty'))
						                                <span class="help-block">
						                                    <strong>{{ $errors->first('faculty') }}</strong>
						                                </span>
						                            @endif
											  </div>											
											  <div class="form-group col-md-6">
											  	<label class="col-form-label"> semester</label>
											  	  <select name='semester_{{$faculty->id}}' class="form-control" required  disabled>
				                            		<option value="1" selected>&#8544;</option>
				                            		<option value="2">&#8545;</option>
				                            		<option value="3">&#8546;</option>
				                            		<option value="4">&#8547;</option>
				                            		<option value="5">&#8548;</option>
				                            		<option value="6">&#8549;</option>
				                            		<option value="7">&#8550;</option>
				                            		<option value="8">&#8551;</option>
				                            	</select>	
											  </div>	  	
										  	
										  </div> 
										@endforeach
	                                </div>
		                        </div>
		                        <div class="form row">
		                        	<div class="col-sm-2">
		                        		<h5><label>project?<label></h5>
		                        	</div>
		                        
		                        	<div class="col-sm-10">
		                        		<label class="radio-inline">
									      <input type="radio" name="project_check" value="1">yes
									    </label>
									    <label class="radio-inline m-l-15">
									      <input type="radio" name="project_check" value="0">no
									    </label>
		                        	</div>
		                        	
		                        </div>
		                          
						  </div>
						  {{--@foreach($permissions as $permission)
							  <li class="list-group-item borderless" >
							  	<input type="checkbox" name="permission_checks[]" value="{{$permission->id}}">
							  	{{$permission->display_name}}
							  	<i class="text-muted" >({{$permission->description}})</i>
							  </li>
							@endforeach --}}
						  <button type="submit" class="btn btn-primary btn-lg btn-block m-t-20">update</button>
					</div>	  <!-- end of panel-->

				</div>
			</div>
		</form>		
	
		
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">

		$(document).ready(function (){

			//for checking tick related subject faculties
			var subject_faculties=[
							@foreach($subject->faculties as $faculty)
								"{{$faculty->id}}",
							@endforeach
							];

				var subject_semester=[
							@foreach($subject->faculties as $faculty)
								"{{$faculty->pivot->semester}}",
							@endforeach
							];
							//alert(subject_semester);
			$.each($("input[name='faculty[]']"), function() {

						for (var i = 0; i < subject_faculties.length; i++) 
						{
							if($(this).val()==subject_faculties[i])
							{
								$(this).prop('checked',true);
								//$("input[name='semester_"+subject_faculties[i]+"'] option[value='"+subject_semester[i]+"']").prop('checked', true);
								//alert($("input[name='semester_"+subject_faculties[i]+"']").val());

							}
						}
		             });

			function faculty_semester($this){
				$select_el=$this.parent().next().children('select');
				if($this.prop('checked'))
				{
					$select_el.prop('disabled', false);
				} else
					$select_el.prop('disabled', true);
			}

			$.each($("input[name='faculty[]']"), function() {
				faculty_semester($(this));
			});

			

			$('input[name="faculty[]"]').change(function (){

				faculty_semester($(this));

			});

			 //for chicking tick the project radio button
			var project_check={{$subject->project}}
			$.each($("input[name='project_check']"), function() {
				if($(this).val()==project_check)
					$(this).prop('checked', true);
			});
		});

		/*
			$.each($("input[name='faculty[]']"), function() {

						for (var i = 0; i < subject_faculties.length*2; i+2) 
						{
							if($(this).val()==subject_faculties[i])
							{
								$(this).prop('checked',true);
								//$("input[name='semester_"+subject_faculties[i]+"']").val(subject_faculties[i+1]);
							}
						}
		             });
		*/
	</script>
@endsection
                   