



@extends('layouts.manage')

@section('content')

	<div class="main-container">

		<div class="row">
			<div class="col-md-6">
				<h1>All Uploads</h1>
		{{bin2hex(openssl_random_pseudo_bytes(30))}}
			</div>
			<div class="col-md-4 col-md-offset-2 ">
				<a href="{{ route('downloads.create') }}" class="btn  btn-primary pull-right"> upload</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">
				<h4>
					<span class="text-muted">includes notes, books, tutorials, labmanual, routine, question collection</span>
					</h4>
				
				
				<table class="table m-t-20">
					<thead>
						<th>id</th>
						<th>Filepath</th>
						<th>Category</th>
						<th>Uploaded by</th>
						<th>published at</th>
						<th>Date Created</th>
						<th>Actions</th>
					</thead>
					<tbody>
						@foreach($downloads as $download)
						<tr>
							<td>{{ $download->id }}</td>
							<td>
								{{ substr(strip_tags($download->filepath),0,38) }} <span style="color: blue"> {{ strlen(strip_tags($download->filepath))>38?'....':'' }} </span>
							</td>
							<td>{{$download->download_category->name}}</td>
							<td>{{ $download->user->name }}</td>
							<td>{{$download->published_at}}</td>
							<td>{{ $download->created_at->toFormattedDateString() }}</td>
							<td >
								<div class="input-group-btn">
							        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
							        <ul class="dropdown-menu dropdown-menu-right">
							          <li><a href="{{ route('downloads.show', [$download->id]) }}" > view </a>
							          </li>
							          <li><a href="{{ route('downloads.edit', [$download->id]) }}"> edit </a>
							          </li>
							         
							          <li role="separator" class="divider"></li>
							          <li><a href="#">Separated link</a></li>
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
							  </div> 	
--}}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<center>
				{{ $downloads->links()}}
				</center>
				</div>
			</div>
		</div>

	</div>
@endsection


