



@extends('layouts.app')

@section('content')

<div class="main-container">
		<!-- heading -->
		<div class="container-fluid w-100" id="top_header" >
			
					 <h2 class="text-center">Discussions</h2>
					 <div class="row">
					 	<div class="col-md-8 offset-md-2">
					 		<div class="input-group input-group-lg">
								  <input type="text" class="form-control" placeholder="search" aria-label="Large" aria-describedby="basic-addon2">
								  <div class="input-group-prepend"> 
								  	<button class="btn btn-default" type="button" id="basic-addon2">
								  	<i class="fas fa-search" style="color:#228AE6"></i> Post
								  </button> 
								</div>
							</div>								

					 	</div>
					 </div>
				
				
		</div>
	       
	
		
	<div class="container-fluid">		
		<div class="row">
			<div class="col-md-10 offset-md-1 "  style="background-color: white;">
			
				<div class="row mt-5 mb-5">
					<div class="col-md-3 m-b-30">
						<div class="row ">
							<div class="col-md-11 offset-md-1    bg_grey" style=" padding: 10px;">

								<div class="form-group " >
									<label> sort by:</label>
									<select class="form-control select-lg" id="sort-by">
										<option value="relevance">relevance</option>
										<option value="date">date </option>
										<option value="view_count">view count</option>
										<option value="comments">comments</option>
									</select>
								</div>
								
								
							</div>
						</div>
						
						<div class="row ">
							<div class="col-md-11 offset-md-1  bg_grey m-t-30 " style=" padding: 10px;">
								<a href="{{route('user.posts.index')}}" class="btn btn-primary btn-block btn-nobg-color">View My Posts</a>

							</div>
						</div>	
						

								
						<div class="row">
							<div class="col-md-11 offset-md-1 mt-1 bg_grey" >
								<label class="mt-2">Popular Tags</label>
								<hr>
								<!--end <div class="nav flex-column nav-pills" id="v-pills-tag" role="tablist" aria-orientation="vertical"> -->
									
									@foreach($popular_tags as $popular_tag)	
									 {{-- <a class="nav-link "  data-toggle="pill" 
									  href="{{route('posts.home')}}" role="tab" aria-controls="v-pills-home" aria-selected="true">
									  	{{$popular_tag->name}} <span class="badge badge-secondary float-right">{{$popular_tag->tagcounts}}</span>
									  </a>
									  <input type="hidden" name="tag_ids" value="{{$popular_tag->tag_ids}}">--}}
									  <!--checkboxes-->
									  <div class="form-check mt-2">
										  <input class="form-check-input" type="checkbox" value="{{$popular_tag->tag_id}}" class="tag_check" >
										  <label class="form-check-label ml-3" >
										    {{$popular_tag->name}}
										  </label>
										  <span class="badge badge-secondary float-right">{{$popular_tag->tagcounts}}</span>
									  </div>	
									   <!--end checkboxes-->
									@endforeach
								
							</div>
						</div>		

					</div>

					<div class="col-md-9 " style="padding: 20px" >
						<div class="row">
							<div class="col-md-8 ">
								<h4 class="text-muted" id="projects_head"></h4>
							</div>
							<div class="col-md-3 offset-md-1  ">
							
								<a href="{{route('user.posts.create')}}" class="btn btn-primary btn-block  float-right"> Create New Post</a>
								
							</div>
						</div>

						<div class="row ">
							<div class="col-md-12 mt-3" id="project_mainbox" >

								<div class="row ">
									<div class="col-md-6 offset-md-3 mt-4 text-center"  >
									 <img src="{{asset('images/infinity-7s-200px.gif')}}" height="300px" width="300px">
									 <div><h4>loading</h4></div>
									</div>
								</div>
								
															{{--{{ substr(strip_tags(),0,60) }} <span style="color: blue"> {{ strlen(strip_tags($project->name ))>60?'....':'' }}--}}
							</div>
						</div>
				
       
						
						<div class="row">
							<div class="col-md-10 offset-md-1 mt-3">
							
								<nav id="pageagination_controls" aria-label="Page navigation" class="text-center invisible">

								  <ul class="pagination justify-content-center">
								    <li class="page-item"><a href="{{route('posts.ajaxIndex')}}?page=1" class="page-link">1</a></li>

									<li class="page-item disabled" id="prev_page_control"><a href="#" class="page-link"> previous </a></li>
									    
									
									 <li class="page-item" id="next_page_control"><a href="#" class="page-link"> next</a></li>
									

								     <li class="page-item"><a href="#" class="page-link"></a></li>
								    
								  </ul>
								</nav>
							</div>
						</div> 
						
					{{-- $projects->links( "pagination::bootstrap-4") --}}
						
					</div>
				</div>
				{{--{{ substr(strip_tags($project->filepath),0,38) }} <span style="color: blue"> {{ strlen(strip_tags($project->filepath))>38?'....':'' }} </span>--}}
				

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
		  var sort_by='relevance';
		  var host='{{url('/')}}';
		  var tag_ids = [];	
		//$('#v-pills-'+category+' input[value="'+cat_id+'"]').prev().prev().addClass('active');
			$('input[type=checkbox]').change(function (){
				 tag_ids = $('input[type=checkbox]:checked').map(function() {
				    return this.value;
				}).get()
				sort_by=$('#sort-by').val();
				getposts(tag_ids, sort_by);
			});

		getposts(tag_ids, sort_by);

		

		$('#sort-by').change(function(){
			sort_by=$(this).val();
			getposts(tag_ids, sort_by);
		});


		
		

		

            $('body').on('click', '.pagination a', function(e) {
            	//prevent default action ,i.e,stop directing to route in a tag's href
                e.preventDefault();
                 url = $(this).attr('href');
           
               getposts(tag_ids, sort_by, url);
                
            });


			//to change page no's in pagination controls
			function paginate_cotrols(currentpage, lastpage)
			{	
				if(lastpage<=1)
					$('.pagination').parent().addClass('invisible');
				else
				{	
					$('.pagination').parent().removeClass('invisible');

					$('.pagination li:last a').attr('href','{{route('posts.ajaxIndex')}}?page='+lastpage).text(lastpage);

					if(currentpage<=1)
						$("#prev_page_control").addClass('disabled');
					else
					{
						$("#prev_page_control").removeClass('disabled').children().attr('href', '{{route('posts.ajaxIndex')}}?page='+(currentpage-1));
					}

					if(currentpage>=lastpage)
						$("#next_page_control").addClass('disabled');
					else
					{
						$("#next_page_control").removeClass('disabled').children().attr('href', '{{route('posts.ajaxIndex')}}?page='+(currentpage+1));
					}
				}
			}


            user_id='{{Auth::user()->id}}';


            function getposts(tag_ids, sort_by, url='{{route('posts.ajaxIndex')}}') 
            {
				
                $.ajax({
                    url : url,
                    data:{ 'token' : '{{csrf_field()}}',
		                   'tag_ids' : tag_ids,
		                   'sort_by' : sort_by
					 },
					 dataType: 'json',
                }).done(function (pdata) {
                	console.log(pdata)
                	$('#project_mainbox').empty();
                	//console.log(data)
              /*      //window.history.pushState("", "", host+'/projects/'+category+'/'+cat_id);
             if(pdata.total!=0)
            {	
                for (j = 0; j < pdata.data.length; j++) 
                {	
                	post = pdata.data[j];

                	tags = ''
                	for(i=0; i<post.tags.length; i++)
                	{
                		tags= tags + '<li class="list-inline-item"><span class="badge badge-success">'+post.tags[i].name+'</span></li>'
                	}
					
					image=''
					col = 'col-md-12'
					if(post.imgs)
					{
						image = '<div class="col-md-4" > <img src="'+post.imgs[0].filepath+'"  class="img-fluid"></div>'
						col = 'col-md-8'
					}								  
												
                    edit_btns =''
                    if(user_id == post.user.id)
                    {
                    	edit_btns = ['<div class="col-md-auto">',
				    		'<div class="container">',
				    			'<a href="'+host+'/user/posts/'+post.slug+'/edit">',
				    			'<i class="fas fa-edit"></i></a>',
				    		'</div>',
				    		'<div class="container">',
				    			'<i class="fas fa-trash-alt"></i>',
				    		'</div>',
				    	'</div>'].join('')
				    }
				    	
                    posts_box=
                    ['<div class="row mt-3" id="posts_box">',

						'<div class="col-md-auto v_align_inner_div" >',
							'<div class="container">',
								'<div class="row">',
									'<div class="col-md-12">',
										'<i class="fas fa-comments fa-3x " ></i>',
									'</div>',
								'</div>',
								'<div class="row">',
									'<div class="col-md-12 text-center" style=" font-size: 2em;">',
										
									'7</div>',
								'</div>',
							'</div>',		
						'</div>',

					   '<div class="col-md-9 card  "  >',
						  '<div class="card-body pt-3 pb-1 pl-1 pr-1">',
					    	'<div class="row" >',
					    		'<div class="'+col+'" >',
					    			
					    		
						    	'<div class="row ">',
						    		'<div class="col-md-12 post-header" >',
						    			'<a href="'+host+'/user/posts/'+post.slug+'" id="post_name" >'+post.content+'</a>',
						    		'</div>',
						    	'</div> ',

						    	'<div class="row ">',
						    		'<div class="col text-muted" >',
						    			'<small>',
						    			'By: '+post.user.name+' <i> [ '+post.user.roll_no+' ]</i>, '+post.created_at,
						    		
						    			'</small>',
						    		'</div>',
						    		
						    	'</div>',

								'<div class="row ">',
									'<div class="col">',
										'<ul class="list-inline">',
											
											tags,
										'</ul>',
									'</div>',
								'</div>',		
				   			'</div>',
				   			//image
				   			image,

				   		    '</div>',
					    	'</div>',

				   		'</div>',
				     
				    	edit_btns,
				    '</div>' ].join('');

				    $('#project_mainbox').append(posts_box); 
				}
			}
			$('#projects_head').text('displaying page '+pdata.current_page+'( of total '+pdata.last_page+' ) from '+pdata.total+' results ');
	                paginate_cotrols(pdata.current_page, pdata.last_page) 
*/
                }).fail(function (error1) {
                	console.log(error1)
                    alert('Articles could not be loaded due to technicle problems.');
                });
            }
        
  

	});
</script>
@endsection
