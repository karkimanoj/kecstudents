



@extends('layouts.manage')

@section('content')

	<div class="main-container">

		<div class="row">
			<div class="col-md-6">
				<h1>All Posts</h1>
	
			</div>
			<div class="col-md-4 offset-md-2 ">
				<a href="{{ route('posts.create') }}" class="btn  btn-primary float-right"> Start Discussion</a>
			</div>

		</div>
		<div class="row">
			<div class="col-md-12">

				@foreach($posts as $post)

					<div class="row mt-3" id="posts_box">

						<div class="col-md-auto v_align_inner_div" >
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<i class="fas fa-comments fa-3x " ></i>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 text-center" style=" font-size: 2em;">
									<a href="{{route('posts.show', $post->slug)}}#disqus_thread" data-disqus-identifier="{{$post->id}}"> 0</a>
									</div>
								</div>
							</div>	
							
							<!--
								<div class="container v_align_inner_div" style="border: 1px solid black;">
								</div>
							<div class="container" style="height:50%; border: 1px solid black;">
								
							</div>-->
							
						
								
						</div>
					    <div class="col-md-9 card "  style="border: 1px solid black">
						
					    
					    	<div class="card-body">
					    	<div class="row" >
					    		<div class="{{($post->imgs()->first()->filepath)? 'col-md-8' : 'col-md-12'}}" >
					    			
					    		
						    	<div class="row ">
						    		<div class="col-md-12" >
						    			<a href="{{route('posts.show', $post->slug)}}" id="post_name" 
									>{{$post->content}}</a>
						    		</div>
						    	</div> 

						    	<div class="row ">
						    		<div class="col text-muted" >
						    			<small>
						    			By: {{ $post->user->name }} <i> [ {{ $post->user->roll_no }} ]</i>, {{($post->created_at )->toDateTimeString()}}
						    			{{-- ->toFormattedDateString() --}}
						    			</small>
						    		</div>
						    		
						    	</div>

								<div class="row ">
									<div class="col">
										<ul class="list-inline">
											
										@foreach($post->tags as $tag)
										  <li class="list-inline-item">
										  	<span class="badge badge-success">{{$tag->name}}
										  	</span>
										  </li>
										@endforeach
										</ul>
									</div>
								</div>		
				   			</div>

				   			@if($post->imgs()->first()->filepath)
				   			<div class="col-md-4" >
				   				<img src="{{asset($post->imgs()->first()->filepath)}}" alt="aa" class="img-thumbnail">
				   			</div>
				   			@endif
				   		    </div>
					    	</div>

				   		</div>
				    
				    	<div class="col-md-auto">
				    		@if(Auth::user()->owns($post, 'author_id'))
				    		<div class="container mt-2">
				    			<a href="{{route('posts.edit', $post->slug)}}">
				    			<i class="fas fa-edit"></i></a>
				    		</div>
				    		@endif
				    		<div class="container mt-2">
				    			<a id="delete_btn{{($post->id)*2}}"  data-toggle="modal" data-target="#myModal" href="#"> <i class="fas fa-trash-alt" ></i></a>
				    			<input type="hidden" value="{{route('posts.destroy',$post->slug)}}">
				    		</div>
				    	</div>
  
					</div>
				@endforeach
				{{ $posts->links("pagination::bootstrap-4")}}
				
			</div>
		</div>

	</div>
@endsection


