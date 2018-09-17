



@extends('layouts.manage')

@section('content')

	<div class="main-container">

		<div class="row">
			<div class="col-md-6">
				<h1>All Events</h1>
	
			</div>
			<div class="col-md-4 offset-md-2 ">
				<a href="{{ route('events.create') }}" class="btn  btn-primary float-right"> Add New Event</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
			
				
				{{--{{ substr(strip_tags($event->filepath),0,38) }} <span style="color: blue"> {{ strlen(strip_tags($event->filepath))>38?'....':'' }} </span>--}}
				<table class="table m-t-20">
					<thead>
						<th>id</th>
						<th>Title</th>
						<th>Type</th>
						
						<th>Date-Time</th>
						
						<th>venue</th>
						<th>Date Created</th>
						<th>Deleted At</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($events as $event)
						<tr>
							<td>{{ $event->id }}</td>
							<td>
							{{ substr(strip_tags($event->title ),0,60) }} <span style="color: blue"> {{ strlen(strip_tags($event->title ))>60?'....':'' }}
							</td>
							<td>{{$event->type}}</td>
							<td>{{$event->start_at.' ~ '.$event->end_at}}</td>
							<td>{{ $event->venue}}</td>
						
							<td>{{ $event->created_at }}</td>
							<td>{{$event->deleted_at}}</td>
							<td >
								
							      
							     <a href="{{ route('events.show', [$event->id]) }}" class="btn btn-primary" role="button"> View </a>
							          
							    </div><!-- /btn-group -->

								<!-- delete with modal-->
								{{--
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">delete</button>
								
									
							  <div class="modal fade " id="myModal" role="dialog">
							    <div class="modal-dialog modal-sm">
							     
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
							        			<form method="POST" action="{{ route('faculties.destroy', $faculty->id) }}" >
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
							  </div> 	
--}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<center>
				
				<div class="row">
		          <div class="col-auto offset-md-4">
		            {{$events->links( "pagination::bootstrap-4") }}
		          </div>
		        </div>
				</center>
				</div>
			</div>
		</div>

	</div>
@endsection


