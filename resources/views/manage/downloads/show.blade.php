
@extends('layouts.manage')

@section('content')
	<div class="main-container">
		<div class="row m-b-20">

			{{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">delete</button>
			--}}
					<!-- Modal -->
			  <div class="modal fade " id="myModal" role="dialog">
			    <div class="modal-dialog modal-sm">
			      <!-- Modal content-->
			      <div class="modal-content">

			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title">Confirm Deletion</h4>
			        </div>

			        <div class="modal-body">
			          <p>Are You Sure?</p>
			        </div>

			        <div class="modal-footer">
			        	<div class="row">
			        		<div class="col-md-6">
			        			<form method="POST" action="{{ route('downloads.destroy', $download->id) }}" >
					        		{{method_field('DELETE')}}
					        		{{csrf_field()}}
					        		<input type="submit" class="btn btn-danger float-right" name="delete" value="yes">
								</form>		
			        		</div>
			        		<div class="col-md-6">
			        			<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
			        		</div>
			        	</div>	
			        </div>
			      </div>
			      
			    </div>
			  </div> <!-- end of modal -->	

			<div class="col-md-10">
				<div class="page-header">
				  <h1>{{$download->id}}. {{$download->download_category->name}} of <small > <i>(
				  	{{ $download->subject_id ? $download->subject->name : $download->faculty->name.' - '.$download->semester }}
				  	
				  	)</i></small></h1>
				</div>
			</div>			
			<div class="col-md-2">
				<div class="input-group-btn">
			        <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
			        <ul class="dropdown-menu dropdown-menu-right">
			          <li><a href="{{ route('downloads.edit', [$download->id]) }}"> Edit </a>
			          </li>
			         <li><a id="publish_btn" href="#">
			         	@if($download->published_at)
			                  unpublish 
			               @else
			               publish
			               @endif
			           </a>
			          </li>
			          <li ><a style="color: red;" data-toggle="modal" data-target="#myModal" href="#">Delete </a>
			          </li>
			        </ul>
				</div><!-- /btn-group -->
				
			</div>
		</div>

		<div class="row">
			<div class="col-md-10">
				
				<div class="panel panel-default">
				  <div class="panel-body">
				    

				    <table class="table table-striped mt-3">
				    	<label>Files:</label>
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Display Name</th>
					      <th scope="col">File Path</th>
					       <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>
					  	@foreach($download->download_files as $file)
					    <tr>
					      <th scope="row">1</th>
					      <td>{{$file->display_name}}</td>
					      <td>{{$file->filepath}}</td>
					      <td><a href="{{ asset($file->filepath) }}"> Download </a></td>
					    </tr>
					   @endforeach
					 
					  </tbody>
					</table>
				  
					 <p>
					<label>Published At: &ensp;</label>		 
				    <span id="publised_at">
				    	{{$download->published_at}}
				    </span>	
				    </p>

				    <p>
					<label>{{ ($download->subject_id) ? 'subject' : 'faculty-semester'}}: &ensp;</label>		 
				    <span >
				    	{{ ($download->subject_id) ? $download->subject->name : $download->faculty->name.' - '.$download->semester }}
				    </span>	
				    </p>
				    	
				    <p>
					<label> Uploader: </label><br> 
				    	{{$download->user->name}} 
				    </p>
				    <p>
					<label> Description: </label><br>		 
				    	{{$download->description}}
				    </p>
				    <p>
					<label> Created At: </label> {{$download->created_at}}<br>		 
				    	<label> Updated At: </label> {{$download->updated_at}}
				    </p>
				    
				  </div>
				
				
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function ()
	{
		$('#publish_btn').click(function()
		{
			status=$(this).text().trim();

			host='{{url('/')}}';
			id={{$download->id}};
			$.ajax({
				type:'GET',
				url: '{{route('downloads.publish')}}',
				data:{ 'id': id,
						'status': status
					 },
				success: function(e){
					if(status=='publish'){
						 $('#publish_btn').text('unpublish');
						 $('#publised_at').text(e);
						 
						}
					else{
						$('#publish_btn').text('publish');
						$('#publised_at').text(e);
						//console.log(e);
					}
				},
				error: function(e){
					console.log(e);
				}	
			});
		});
	});
</script>
@endsection
