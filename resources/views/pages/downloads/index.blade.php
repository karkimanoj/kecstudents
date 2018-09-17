



@extends('layouts.app')

@section('content')

<div class="main-container">
		<!-- heading -->
	<div class="container-fluid w-100" id="top_header" >
		 <h2 class="text-center">All Downloads</h2>
		 <div class="row">
		 	<div class="col-md-8 offset-md-2">
		 		<div class="input-group input-group-lg">
					   <input type="text" minlength="3" class="form-control" placeholder="search with 3 or more characters" aria-label="search" aria-describedby="basic-addon2" id="search_field">
					  <div class="input-group-prepend"> 
					  	<button class="btn btn-default" type="button" id="search_btn">
					  	<i class="fas fa-search" style="color:#228AE6"></i> Downloads
					  </button> 
					</div>
				</div>								

		 	</div>
		 </div>				
	</div>
	       
	
		
	<div class="container-fluid">		
		<div class="row">
			<div class="col-md-10 offset-md-1 "  style="background-color: white;">

				<div class="row ">
					<div class="col-md-12 mt-1  " style=" padding: 10px;">

						

						<div class="row mt-3">
							<div class="col-md-3  " >
								<div class="row ml-3 bg_grey">
									<div class="col-md-12 p-1 form-group ">
										<label> Sort by:</label>
										<select class="form-control select-lg" id="sort-by">
											<option value="relevance">relevance</option>
											<option value="date">date </option>
											<option value="view_count">view count</option>
											<option value="comments">comments</option>
										</select>
									</div>
								</div>
							</div>
							
							<div class="col-md-9">
								<div class="row ml-1 mr-1 bg_grey" >
								<div class="col-md-4 p-1 form-group" >
									<label> Faculty:</label>
									<select class="form-control select-lg" id="faculty_select">
										@foreach( $faculties as $faculty )
											<option value="{{$faculty->id}}">{{$faculty->name}}</option>
										@endforeach
									</select>
								</div>

								<div class="col-md-4 p-1 form-group " >
									<label> Semester:</label>
									<select class="form-control select-lg" id="semester_select">
										<option value="1">First</option>
										<option value="2">Second</option>
										<option value="3">Third</option>
										<option value="4">Fourth</option>
										<option value="5">Fifth</option>
										<option value="6">Sixth</option>
										<option value="7">Seventh</option>
										<option value="8">Eigth</option>
										
									</select>
								</div>

								<div class="col-md-4 p-1 form-group " >
									<label> Subjects:</label>
									<select class="form-control select-lg" id="subject_select">
										
										
									</select>
								</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="row  mb-5">
					<div class="col-md-3 mb-3">

						<!--<div class="row">
							<div class="col-md-3 offset-md-9">
								<a href="{{--route('user.downloads.create')--}}" class="btn btn-primary btn-block  float-right"> upload </a>
							</div>
						</div>-->
						<div class="row ">
							<div class="col-md-11 offset-md-1   mt-1 " style=" padding: 10px;">
								<a href="{{route('user.downloads.create')}}" class="btn btn-outline-success btn-block btn-sm" >Upload New File/s</a>

							</div>
						</div>	
						@if(Auth::user()->hasRole('teacher'))
						<div class="row ">
							<div class="col-md-11 offset-md-1   mt-1 " style=" padding: 10px;">
								<a href="{{route('user.downloads.index')}}" class="btn btn-outline-success btn-block btn-sm" >View My Uploads</a>

							</div>
						</div>
						@endif		
						
						<div class="row">
							<div class="col-md-11 offset-md-1 mt-1 bg_grey" >
								<div class="nav flex-column nav-pills" id="v-pills-category" role="tablist" aria-orientation="vertical">
									@foreach($categories as $download_category)
									  <a class="nav-link "  data-toggle="pill" href="{{route('downloads.home', ['category_id'=> $download_category->id] )}}" role="tab" aria-controls="v-pills-home" aria-selected="true">
									  	{{$download_category->name}} <span class="badge badge-secondary float-right"> {{$download_category->downloads->count()}}</span>
									  </a>
									@endforeach
								</div>
						
							</div>
						</div>

								
							

					</div>

					<div class="col-md-9 " style="padding: 20px" >
						<div class="row">
							<div class="col-md-8 ">
								<h4 class="text-muted" id="downloads_head"></h4>
							</div>
							
						</div>

						<div class="row ">
							<div class="col-md-12 mt-3" id="downloads_mainbox" >

								<div class="row ">
									<div class="col-md-6 offset-md-3 m-t-30 text-center"  >
										<img src="{{asset('images/infinity-7s-200px.gif')}}" height="300px" width="300px">
										<div><h4>loading</h4></div>
									</div>
								</div>
								
							</div>
						</div>
				
       
						
						<div class="row">
							<div class="col-md-10 offset-md-1 mt-3">
							
								<nav id="pagination_controls" aria-label="Page navigation" class="text-center invisible">

								  <ul class="pagination justify-content-center">
								    <li class="page-item"><a href="{{route('page.downloads.ajaxCall')}}?page=1" class="page-link">1</a></li>

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
		var category_id='{{$category_id}}';
		//var sort_by='relevance';
		var host='{{url('/')}}';
		var subjects_json=@json($fac_sem_sub_arr);
        var all_subjects=JSON.parse(subjects_json);
        
		$('a[href="'+host+'/downloads/'+category_id+'"]').addClass('active');

        /*
            function to show subject according to faculty/semester
        */
        function subjects()
        {
            fac=$('#faculty_select').val();
            sem=$('#semester_select').val();

            $('#subject_select').html('');

            for(x in all_subjects[fac][sem])
            {       
                $('#subject_select').append('<option value='+x+'>'+all_subjects[fac][sem][x]+'</option>');    
            }
        }

        subjects();   
        getDownloads(category_id);

        $(document).on('change','#faculty_select, #semester_select', function(){
            subjects();
            $('#search_field').val('');
            getDownloads(category_id);
        });

		

		$('#v-pills-category a').click(function()
		{
			category_id=$(this).attr('href').split('downloads/')[1];

			
			getDownloads(category_id);
		});

		$('#sort-by, #subject_select').change(function(){
			 $('#search_field').val('');
			getDownloads(category_id);
		});

		$('#search_btn').on('click', function(){
			
			getDownloads(category_id);

		});
		
		

		

            $('body').on('click', '.pagination a', function(e) {
            	//prevent default action ,i.e,stop directing to route in href
                e.preventDefault();
                 url = $(this).attr('href');
               
               getDownloads(category_id,  url);
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

					$('.pagination li:last a').attr('href','{{route('page.downloads.ajaxCall')}}?page='+lastpage).text(lastpage);

					if(currentpage<=1)
						$("#prev_page_control").addClass('disabled');
					else
					{
						$("#prev_page_control").removeClass('disabled').children().attr('href', '{{route('page.downloads.ajaxCall')}}?page='+(currentpage-1));
					}

					if(currentpage>=lastpage)
						$("#next_page_control").addClass('disabled');
					else
					{
						$("#next_page_control").removeClass('disabled').children().attr('href', '{{route('page.downloads.ajaxCall')}}?page='+(currentpage+1));
					}
				}
			}


            userroll='{{Auth::user()->roll_no}}';

            

            function getDownloads(category_id, url='{{route('page.downloads.ajaxCall')}}'  ) 
            {	
               	sort_by=$('#sort-by').val();
            	faculty_id=$('#faculty_select').val();
            	semester_id=$('#semester_select').val();
            	subject_id=$('#subject_select').val();
            	search_text = $('#search_field').val();
            	if(search_text.length < 3)
            	   search_text = '';

                $.ajax({
                	type :'GET',
                    url : url,
                    dataType:'JSON',
                    data:{	'token' : '{{csrf_token()}}',
                    	 	'category_id' : category_id,
		                   'sort_by' : sort_by,
		                   'faculty_id' : faculty_id,
		                   'semester' : semester_id,
		                   'subject_id' : subject_id,
		                   'search_text' : search_text
					 },
                }).done(function (object) {
                	
                   //var object=JSON.parse(data1);
                    //console.log(object);
                    //window.history.pushState("", "", host+'/downloads/'+category_id);
                    
                    $('#downloads_mainbox').empty();

                    
                 
   
                    if(object.total!=0)
                    {	
	                    for (j = 0; j < object.data.length; j++) 
	                    {
	                    	download=object.data[j];
								
							downloadId=download.id
								

		                    name_div=' <div class="row m-t-10">  <div class="col-md-12" >  <a href="'+host+'/user/downloads/'+downloadId+'" id="download_name">'+download.title+'</a></div></div> ';

	                    	user_date_div='<div class="row m-t-10">											<div class="col-md-6" >												<i class="fas fa-user"></i> 									'+download.user.name+'									</div>															<div class="col-md-6" >												<i class="far fa-clock"></i>								'+download.published_at+'										</div>														</div>';
	                  

	                    	count_description_div='<div class="row m-t-10"> <div class="col-md-6" >	<button class="btn btn-info btn-sm">'+download.download_files.length+' file/s</button></div>										<div class="col-md-6" ></i> <button type="button" class="btn btn-sm btn-info" data-toggle="popover" title="Description"  data-content="'+download.description +'">description</button> </div></div>';

	                    	
							/*
	                    	show_edit_div='';
		                    	if(download.user.roll_no == userroll)
	                    		{
	                    			show_edit_div='<div class="row m-t-10"> <div class="col-md-6 " >					<a href="'+host+'user/downloads/'+download.id+'" class="btn btn-primary btn-sm btn-nobg-color">view</a>													</div><div class="col-md-6 " >												<a href="'+host+'user/downloads/'+download.id+'/edit" 					 class="btn btn-outline-primary btn-sm ">edit</a> 									</div></div>';
	                    		}*/
	                    	
	                    	comment_div =['<div class="col-md-auto v_align_inner_div" >',
							'<div class="container">',
								'<div class="row">',
									'<div class="col-md-12">',
										'<i class="fas fa-comments fa-3x " ></i>',
									'</div>',
								'</div>',
								'<div class="row">',
									'<div class="col-md-12 text-center" style=" font-size: 2em;">',
										
									'<a href="'+host+'/user/downloads/'+download.id+'#disqus_thread" data-disqus-identifier="'+download.id+'"> 0</a></div>',
								'</div>',
							'</div>',		
						'</div>'].join('');

						edit_btns =''
                    if(download.user.roll_no == userroll)
	                {
                    	edit_btns = ['<div class="col-md-auto">',
				    		'<div class="container">',
				    			'<a href="'+host+'/user/downloads/'+download.id+'/edit">',
				    			'<i class="fas fa-edit"></i></a>',
				    		'</div>',
				    		'<div class="container">',
				    			'<i class="fas fa-trash-alt"></i>',
				    		'</div>',
				    	'</div>'].join('')
				    }
	                    	   
	                    	download_main_div='<div class="row m-t-30 " id="project_box">'+comment_div+'								<div class="col-md-8  border_purple" style=" padding: 0px 20px 15px 20px;" >    																				'+name_div+user_date_div+count_description_div+ '</div>'+edit_btns+'</div>';
	                    	
	                        $('#downloads_mainbox').append(download_main_div); 
	                        
	                    }

	                    $(function () {
						  $('[data-toggle="popover"]').popover()
						})
	                }  

	                if(search_text.length >= 3)
	                	head_text = object.total+' search results for '+"'"+search_text+"'";
	                else
	                head_text = 'displaying page '+object.current_page+'( of total '+object.last_page+' ) from '+object.total+' results ';

	              	$('#downloads_head').text(head_text);
	                paginate_cotrols(object.current_page, object.last_page) 
                    
                }).fail(function () {
                    alert('downloads could not be loaded due to technicle problems.');
                });
            }
        
  

	});
</script>
@endsection

