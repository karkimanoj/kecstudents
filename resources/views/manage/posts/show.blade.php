
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
			        			<form method="POST" action="{{ route('posts.destroy', $post->slug) }}" >
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
				  <h1>View Post </h1>
				</div>
			</div>			
			<div class="col-md-2">
				<div class="input-group-btn">
			        <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
			        <ul class="dropdown-menu dropdown-menu-right">
			          <li><a href="{{ route('posts.edit', [$post->slug]) }}"> edit </a>
			          </li>
			       
			          <li ><a style="color: red;" data-toggle="modal" data-target="#myModal" href="#">delete </a>
			          </li>
			        </ul>
				</div><!-- /btn-group -->
				
			</div>
		</div>

		<div class="row">
			<div class="col-md-10">
				
				<div class="card  card_shadow mt-3">
					<div class="card-body">

						<div class="row ">
							<div class="col">
								<h3 class="post-header">{{$post->content}}</h> 
							</div>
						</div>
						<div class="row ">
							<div class="col mt-2">
								<label>Slug :</label> {{$post->slug}}
							</div>
						</div>
						

						<div class="row ">
							<div class="col mt-2">
								<span class="text-muted"><label>Created at: </label>{{ $post->created_at->toDateTimeString()}}, <label>Updated at: </label>  {{($post->updated_at )->toDateTimeString() }}</span>
							</div>
						</div>
						<div class="row ">
							<div class="col mt-2">
								<span class="text-monospace"> By {{ $post->user->name}} [{{$post->user->roll_no}}],  
								@foreach($post->user->roles as $role)
									
									 @if (!$loop->last)
								        {{$role->name}}|
								    @else
								    	{{$role->name}}
								    	@endif
								@endforeach
							</span>
							</div>
						</div>

						<div class="row" >
							
							<div class="col-md-auto mt-2">
								<ul class="list-inline">
									
									@foreach($post->tags as $tag)
								    <li class="list-inline-item">
								  	 <span class="badge badge-success">{{$tag->name}}
								  	 </span>
								    </li>
									@endforeach
								</ul>
							</div>
							<div class="col-md-auto mt-2">
								<i class="fas fa-eye fa-lg"></i> <span class="text-primary">{{$post->view_count}} 
							</div>
						</div>
						@if(count($post->imgs))
						<div class="row">
							<div class="col-md-12 mt-2">
								 <img src="{{asset($post->imgs()->first()->filepath)}}"  width="100%" class="img-fluid" alt="Responsive image">
							</div>
						</div>
						@endif

					</div>
				</div>
				
			</div>
		</div>
	</div>
@endsection


