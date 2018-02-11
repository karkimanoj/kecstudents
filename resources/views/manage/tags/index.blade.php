



@extends('layouts.manage')

@section('content')
	<div class="main-container">
				


		<div class="row">
			<div class="col-md-4">
				<h1>Tags</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<table class="table">
					<thead>
						<th>id</th>
						<th>Name</th>
						<th>created by</th>
						<th>Actions</th>
					</thead>
					<tbody>
						@foreach($tags as $tag)
						<tr>
							<td>{{ $tag->id }}</td>
							<td>{{ $tag->name }}</td>
							<td>{{ $tag->created_by }}</td>
							
							{{--<td>{{ $user->created_at->toFormattedDateString() }}</td>
							<td class="text-center">
								<a href="{{ route('users.show', [$user->id]) }}" class="btn btn-default"> view </a>
								<a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-default "> edit </a>
							</td>
							--}}
							<td>
							  <a class="btn btn-danger" data-toggle="modal" data-target="#myModal" href="#">delete </a>
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
							          <p>Are you sure to delete {{$tag->name}}?</p>
							        </div>

							        <div class="modal-footer">
							        	<div class="row">
							        		<div class="col-md-6">
							        			<form method="POST" action="{{ route('tags.destroy', $tag->id) }}" >
									        		{{method_field("DELETE")}}
									        		{{csrf_field()}}
									        		<input type="submit" class="btn btn-danger pull-right" name="delete" value="yes">
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
							</td>
						</tr>

						@endforeach
					</tbody>
				</table>
				
				<center>
				{{ $tags->links()}}
				</center>
			 </div>
			
		</div>
	</div>
@endsection


