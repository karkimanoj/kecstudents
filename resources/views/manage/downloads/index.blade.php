



@extends('layouts.manage')

@section('content')

	<div class="main-container">

		<div class="row">
			<div class="col-md-6">
				<h1>All Uploads</h1>
	
			</div>
			<div class="col-md-4 offset-md-2 ">
				<a href="{{ route('downloads.create') }}" class="btn  btn-primary float-right"> Upload</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<h4>
					<span class="text-muted">Includes Notes, Books, Tutorials, Lab Manual, Routine, Question Collection</span>
					</h4>
				
				
				<table class="table m-t-20">
					<thead>
						<th>ID</th>
						<th>Title</th>
						<th>Category</th>
						<th>Uploaded By</th>
						<th>Published At</th>
						<th>Date Created</th>
						<th>Actions</th>
					</thead>
					<tbody>
						@foreach($downloads as $download)
						<tr>
							<td>{{ $download->id }}</td>
							<td> {{ $download->title }} </td>
								
							<!--<td> 
								 substr(strip_tags($download->filepath),0,38)  <span style="color: blue"> strlen(strip_tags($download->filepath))>38?'....':''  </span>
							</td>-->
							<td>{{$download->download_category->name}}</td>
							<td>{{ $download->user->name }}</td>
							<td>{{$download->published_at}}</td>
							<td>{{ $download->created_at->toFormattedDateString() }}</td>
							<td >
								<div class="input-group-btn">
							        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
							        <ul class="dropdown-menu dropdown-menu-right">
							          <li><a href="{{ route('downloads.show', [$download->id]) }}" > View </a>
							          </li>
							          <li><a href="{{ route('downloads.edit', [$download->id]) }}"> Edit </a>
							          </li>
							         
							          <li role="separator" class="divider"></li>
							          <li><a href="#">Separated Link</a></li>
							        </ul>
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
				{{ $downloads->links( "pagination::bootstrap-4")}}
				</center>
				</div>
			</div>
		</div>

	</div>
@endsection


