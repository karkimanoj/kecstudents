
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
			        			<form method="POST" action="{{ route('events.destroy', $event->id) }}" >
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
				 <center><h1>VIEW EVENT </h1></center> 
				</div>
			</div>			
			<div class="col-md-2">
				<div class="input-group-btn">
			        <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
			        <ul class="dropdown-menu dropdown-menu-right">
			          <li><a href="{{ route('events.edit', [$event->id]) }}"> edit </a>
			          </li>
			         <li><a id="disable_btn" href="#">
			         	@if($event->deleted_at)
			                 activate
			               @else
			               deactivate
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
			<div class="col-md-9 offset-md-1 p-4" style="background-color: white">
					<div class="row mt-4">
						<div class="col">
							<h4 >{{$event->title}}</h4> 
							<div class="row" style="font-size: 0.9rem">
								<div class="col-md-6">
									<i class="fas fa-user" ></i> <span class="text-primary">{{$event->user->name}} <i>[{{$event->user->roll_no}}]</i></span>
								</div>
								<div class="col-md-6">
									<i class="far fa-clock" style="color:#228AE6;"></i> <span class="text-muted">{{$event->created_at->toFormattedDateString()}}</span>

								</div>
							</div>
							<div class="row mt-2" style="font-size: 0.9rem">
								<div class="col-md-6">
									<label>Updated At: </label> <span class="text-muted"> {{$event->updated_at->toFormattedDateString()}}</span>
								</div>
								<div class="col-md-6">
									<label>Deleted At: </label> <span class="text-muted" id="deleted_at"> 
										@if($event->deleted_at) 
										 '{{ $event->deleted_at->toFormattedDateString()}}'
										@endif
									</span>
								</div>
							</div>	
							

							<hr>
							</div>
							
						
					</div>
					<div class="row ">
						<div class="col-md-4">

							<div class="row mt-4" >
								<div class="col">
									<i class="fas fa-comments fa-3x"></i> <span style="font-size: 2rem;"> 3</span>
								</div>
							</div>
							<div class="row mt-4" >
								<div class="col">
									<i class="fas fa-eye fa-2x"></i> <span style="font-size: 2rem;"> 120</span>
								</div>
							</div>			
							
						</div>

						<div class="col-md-8 mt-3">
							<div class="row">
								<div class="col">
									<label>slug :</label>
									 {{$event->slug}}
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
									<label>Type :</label>
									<span  class="badge text-white" id="event_type_span"> {{$event->type}} </span>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
								<label>Venue :</label>
									
									 {{$event->venue}}
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
								<label>Max members :</label>
									{{$event->max_members}}
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
									<label>Start Date-Time</label>
									 {{--(new Carbon($event->start_at))->toDateTimeString()--}}
									 {{(new Carbon\Carbon($event->start_at))->format(' jS \\of F Y h:i A')}}
								</div>
							</div>
							<div class="row mt-3">
								<div class="col">
									<label>End Date-Time</label>
									 {{--(new Carbon($event->start_at))->toDateTimeString()--}}
									 {{(new Carbon\Carbon($event->end_at))->format(' jS \\of F Y h:i A')}}
								</div>
							</div>
							<div class="row">
								<div class="col mt-3 " style="color: rgba(0,0,0,.84); ">
									<label>Description :</label>
									<p>
										{!!$event->description!!}
									</p>
								</div>
							</div>

							
							<div class="row">								
									<div class="col-md-12 mt-5">
										<label>Members joined ({{$event->event1_members->count()}})</label>
										<ul class="list-unstyled">
										@foreach($event->event1_members as $member)
											<li>{{$member->user->name}} [{{$member->user->roll_no}}]
											</li> 
										@endforeach
										</ul>
									</div>
								
							</div>
						
							<div class="row">								
								<div class="col-md-12 mt-5">
									<label>Members Interested ({{$interested_members->count()}})</label>
									<ul class="list-unstyled">
									@foreach($interested_members as $member)
										<li>{{$member->user->name}} [{{$member->user->roll_no}}]
										</li> 
									@endforeach
									</ul>
								</div>
							
							</div>

								
								
						</div>

					</div>

					<div class="row">
						<div class="col-md-12 text-center">
							<hr>	
							<h1>Comments</h1>
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
		eventType = '{{$event->type}}'

		if(eventType == 'study')
			$('#event_type_span').css('background-color', '#7F0180')
		else if(eventType == 'entertainment')
			$('#event_type_span').css('background-color', '#007F00')
		else
		$('#event_type_span').css('background-color', '#d50000')

		$('#disable_btn').click(function()
		{
			status1=$(this).text().trim();
			
			
			id='{{$event->id}}';
			alert(status1)
			$.ajax({
				type:'GET',
				url:'{{route('events.softDelete')}}' ,
				dataType : 'JSON',
				data:{
					'id': id,
						'status1': status1
					 },
				success: function(e){
					//console.log(e )
					
					if(status1=='activate')
					{
						$('#disable_btn').text('deactivate');
						$('#deleted_at').text(e);
						 
					}
					else{
						$('#disable_btn').text('activate');
						$('#deleted_at').text(e);
						//console.log(e);
					}
				},
				error: function(e){
					console.log(e)
				}	
			});
		});
	});
</script>
@endsection
