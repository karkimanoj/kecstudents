
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
			          <h4 class="modal-title">Confirm deletion</h4>
			        </div>

			        <div class="modal-body">
			          <p>Are you sure?</p>
			        </div>

			        <div class="modal-footer">
			        	<div class="row">
			        		<div class="col-md-6">
			        			<form method="POST" action="{{ route('projects.destroy', $project->id) }}" >
					        		{{method_field("DELETE")}}
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
				  <h1>{{$project->id}}. {{$project->name}} </h1>
				</div>
			</div>			
			<div class="col-md-2">
				<div class="input-group-btn">
			        <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
			        <ul class="dropdown-menu dropdown-menu-right">
			          <li><a href="{{ route('projects.edit', [$project->id]) }}"> edit </a>
			          </li>
			         <li><a id="publish_btn" href="#">
			         	@if($project->published_at)
			                  unpublish 
			               @else
			               publish
			               @endif
			           </a>
			          </li>
			          <li ><a style="color: red;" data-toggle="modal" data-target="#myModal" href="#">delete </a>
			          </li>
			        </ul>
				</div><!-- /btn-group -->
				
			</div>
		</div>

		<div class="row">
			<div class="col-md-10">
				
				<div class="panel panel-default">
				  <div class="panel-body">
				  	<p>
					<label> created at: </label> {{$project->created_at}}<br>		 
				    	<label> updated at: </label> {{$project->updated_at}}
				    </p>
				     <p>
					<label>published at: &ensp;</label>		 
				    <span id="publised_at">
				    	{{$project->published_at}}
				    </span>	
				    </p>
				    @if($project->url_link)
					    <p>
						<label>github link: </label><br>		 
					    	{{$project->url_link}} 
					    </p>
					 @endif
				    <p>
					<label>filepath: </label><br>		 
				    	{{$project->filepath}} 
				    </p>
				    <p>
					<label>original filename:</label><br>		 
				    	{{$project->original_filename}}
				    </p>
				    <p>
					<label> uploader: </label><br> 
				    	{{$project->user->name}} 
				    </p>
				    <p>
					<label> Astract: </label><br>		 
				    	{!!$project->abstract!!}
				    </p>
				    <p>
				    	<label>Members</label><br>
				    	<ul>				    		
				    	@foreach($project->project_members as $member)
				    		<li>{{ $member->name }} <i>[ {{$member->roll_no}} ]</i></li> 
				    	@endforeach
				    	</ul>
				    </p>
				    <center><a href="{{ asset($project->filepath) }}" style="color:blue">click to download this file</a></center>
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
			id={{$project->id}};
			$.ajax({
				type:'GET',
				url:host+'/manage/projects/publish' ,
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
