



@extends('layouts.app')

@section('content')

<div class="main-container">
		<!-- heading -->
		<div class="container-fluid w-100" id="top_header" >
			
					 <h2 class="text-center">All Projects</h2>
					 <div class="row">
					 	<div class="col-md-8 offset-md-2">
					 		<div class="input-group input-group-lg">
								  <input type="text" minlength="3" class="form-control" placeholder="search with 3 or more characters" aria-label="search" aria-describedby="basic-addon2" id="search_field">
								  <div class="input-group-prepend"> 
								  	<button class="btn btn-default" type="button" id="search_btn">
								  	<i class="fas fa-search" style="color:#228AE6"></i> projects
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
						@if(Auth::user()->hasRole('student'))
						<div class="row ">
							<div class="col-md-11 offset-md-1  bg_grey m-t-30 " style=" padding: 10px;">
								<a href="{{route('user.projects.index')}}" class="btn btn-primary btn-block btn-nobg-color">view my projects</a>

							</div>
						</div>	
						@endif	
						
						<div class="row">
							<div class="col-md-11 offset-md-1  bg_grey" >
								<div class="nav flex-column nav-pills" id="v-pills-subject" role="tablist" aria-orientation="vertical">
									<a class="nav-link "  data-toggle="pill" href="{{route('projects.home', ['category'=>'subject', 'cat_id'=>0 ] )}}" role="tab" aria-controls="v-pills-home" aria-selected="true">
									  	All projects
								  		<span class="badge badge-light float-right">{{App\Project::all()->count()}}</span>
									</a>


									@foreach($categories as $project_category)
									  <a class="nav-link "  data-toggle="pill" href="{{route('projects.home', ['category'=>'subject', 'cat_id'=>$project_category->id] )}}" role="tab" aria-controls="v-pills-home" aria-selected="true">
									  	{{$project_category->name}} <span class="badge badge-secondary float-right"> {{$project_category->projects->count()}}</span>
									  </a>
									
									@endforeach
								</div>
						
							</div>
						</div>

								
						<div class="row">
							<div class="col-md-11 offset-md-1 mt-3 bg_grey" >
								<span>popular tags</span>
								<hr>
								<div class="nav flex-column nav-pills" id="v-pills-tag" role="tablist" aria-orientation="vertical">
									@foreach($popular_tags as $popular_tag)	
									  <a class="nav-link "  data-toggle="pill" 
									  href="{{route('projects.home', ['category'=>'tag', 'cat_id'=>$popular_tag->tag_id] )}}" role="tab" aria-controls="v-pills-home" aria-selected="true">
									  	{{$popular_tag->name}} <span class="badge badge-secondary float-right">{{$popular_tag->tagcounts}}</span>
									  </a>
									
									@endforeach
								</div>
							</div>
						</div>		

					</div>

					<div class="col-md-9 " style="padding: 20px" >
						<div class="row">
							<div class="col-md-8 ">
								<h4 class="text-muted" id="projects_head"></h4>
							</div>
							<div class="col-md-3 offset-md-1  ">
							
								<a href="{{route('user.projects.create')}}" class="btn btn-primary btn-block  float-right"> upload new project</a>
								
							</div>
						</div>

						<div class="row ">
							<div class="col-md-12 m-t-30" id="project_mainbox" >

								<div class="row ">
									<div class="col-md-6 offset-md-3 m-t-30 text-center"  >
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
								    <li class="page-item"><a href="{{route('projects.ajaxIndex')}}?page=1" class="page-link">1</a></li>

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
		var category='{{$cat}}';
		 var cat_id={{$cat_id}};
		  //var sort_by='relevance';
		  var host='{{url('/')}}';
	
		//$('#v-pills-'+category+' input[value="'+cat_id+'"]').prev().prev().addClass('active');
		$('a[href="'+host+'/projects/'+category+'/'+cat_id+'"]').addClass('active'); 
		getprojects(category, cat_id);

		$('#v-pills-subject a, #v-pills-tag a').click(function()
		{
			category_array=$(this).attr('href').split('projects/')[1].split('/');

			category=category_array[0];
			cat_id=category_array[1];
			(category=='subject') ? $('#v-pills-tag').children('a.active').removeClass('active') : $('#v-pills-subject').children('a.active').removeClass('active') ;
			
			getprojects(category, cat_id);
		});

		$('#sort-by').change(function(){
			$('#search_field').val('');
			getprojects(category, cat_id);
		});


		$('#search_btn').on('click', function(){
			
			getprojects(category, cat_id);

		});
		

		

            $('body').on('click', '.pagination a', function(e) {
            	//prevent default action ,i.e,stop directing to route in a tag's href
                e.preventDefault();
                 url = $(this).attr('href');
               //$active_class=$(this).parent();
                //host='{{--url('/')--}}';
               // page=url.split('?')[1];
               //$deactive_class=$('.pagination').children('li.active');
                //console.log($deactive_class);
                //url=host+'/projects/ajaxIndex?'+page;
               // alert(url);
               getprojects(category, cat_id,  url);
                //window.history.pushState("", "", url);  this will insert the new url with page=no .here we dont need this
            });


			//to change page no's in pagination controls
			function paginate_cotrols(currentpage, lastpage)
			{	
				if(lastpage<=1)
					$('.pagination').parent().addClass('invisible');
				else
				{	
					$('.pagination').parent().removeClass('invisible');

					$('.pagination li:last a').attr('href','{{route('projects.ajaxIndex')}}?page='+lastpage).text(lastpage);

					if(currentpage<=1)
						$("#prev_page_control").addClass('disabled');
					else
					{
						$("#prev_page_control").removeClass('disabled').children().attr('href', '{{route('projects.ajaxIndex')}}?page='+(currentpage-1));
					}

					if(currentpage>=lastpage)
						$("#next_page_control").addClass('disabled');
					else
					{
						$("#next_page_control").removeClass('disabled').children().attr('href', '{{route('projects.ajaxIndex')}}?page='+(currentpage+1));
					}
				}
			}


            userroll='{{Auth::user()->roll_no}}';


            function getprojects(category, cat_id,  url='{{route('projects.ajaxIndex')}}') 
            {	
            	sort_by = $('#sort-by').val();
            	search_text = $('#search_field').val();
            	if(search_text.length < 3)
            	   search_text = '';

                $.ajax({
                    url : url,
                    data:{ '_token' : '{{csrf_token()}}',
                    		'category' : category,
		                   'cat_id' : cat_id,
		                   'sort_by' : sort_by,
		                   'search_text' : search_text
					 },
                }).done(function (data) {

                    object=JSON.parse(data);
                    
                    window.history.pushState("", "", host+'/projects/'+category+'/'+cat_id);
                    
                    $('#project_mainbox').empty();
                    //console.log(object)

                    if(object.total!=0)
                    {	
	                    for (j = 0; j < object.data.length; j++) 
	                    {
	                    	project=object.data[j];
								
								projectId=project.id;

							comment_div =['<div class="col-md-auto v_align_inner_div" >',
							'<div class="container">',
								'<div class="row">',
									'<div class="col-md-12">',
										'<i class="fas fa-comments fa-3x " ></i>',
									'</div>',
								'</div>',
								'<div class="row">',
									'<div class="col-md-12 text-center" style=" font-size: 2em;">',
										
									'<a href="'+host+'/user/projects/'+project.id+'#disqus_thread" data-disqus-identifier="'+project.id+'"> 0</a></div>',
								'</div>',
							'</div>',		
						'</div>'].join('');	

								
		                    name_div=' <div class="row m-t-10">  <div class="col-md-12" >  <a href="'+host+'/user/projects/'+projectId+'" id="project_name">'+project.name+'</a>																				</div></div> ';

	                    	user_subject_div='<div class="row m-t-10">											<div class="col-md-6" >												<i class="fas fa-user"></i> 									'+project.user.name+'									</div>															<div class="col-md-6" >												<i class="fab fa-cuttlefish"></i>								'+project.subject.name+'										</div>														</div>';
	                   
	                    	tags_div='';

	                    	for ( i = 0; i < project.tags.length; i++) 
	                    	{	
	                    		tags_div+='<a href="'+host+'/projects/tag/'+project.tags[i].id+'" > <span class="badge badge-success ml-2"> '+project.tags[i].name+' </span> </a>';
									     				
	                    	}

	                    	tags_user_div='<div class="row m-t-10"> <div class="col-md-6" >						<i class="fas fa-tags"></i>'+tags_div+'</div>										<div class="col-md-6" ><i class="far fa-clock"></i>'+project.created_at+'</div></div>';

	                    	edit_btns='';
	                    	
	                    	for ( i = 0; i < project.project_members.length; i++) 
	                    	{
	                    		if(project.project_members[i].roll_no==userroll)
	                    		{
	                    			

	                    			edit_btns = ['<div class="col-md-auto">',
						    		'<div class="container">',
						    			'<a href="'+host+'/user/projects/'+project.id+'/edit">',
						    			'<i class="fas fa-edit"></i></a>',
						    		'</div>',
						    		'<div class="container">',
						    			'<i class="fas fa-trash-alt"></i>',
						    		'</div>',
						    	'</div>'].join('');
	                    		}
	                    	}
	                    	   
	                    	project_main_div='<div class="row m-t-30 " id="project_box">'+comment_div+'								<div class="col-md-8  border_purple" style=" padding: 0px 20px 15px 20px;" >    																				'+name_div+user_subject_div+tags_user_div+ '</div>'+edit_btns+'</div>';
	                    	
	                        $('#project_mainbox').append(project_main_div); 
	                    }
	                }  

	                if(search_text.length >= 3)
	                	head_text = object.total+' search results for '+"'"+search_text+"'";
	                else
	                head_text = 'displaying page '+object.current_page+'( of total '+object.last_page+' ) from '+object.total+' results ';

	              	$('#projects_head').text(head_text);
	                paginate_cotrols(object.current_page, object.last_page) 
                    //var arr = $.map(object.data[0], function(el) { return el });
                }).fail(function (error1) {
                	console.log(error1)
                    alert('Articles could not be loaded due to technicle problems.');
                });
            }
        
  

	});
</script>
@endsection
