@extends('layouts.app')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>/*
      tinymce.init({ selector:'textarea',
              menubar:'false',
              plugins:'code link' });*/
  </script>

@endsection

@section('content')

<div class="main-container">
		<!-- heading -->
		<div class="row ml-0 mr-0">
			<div class="col-md-12" id="top_header" >
				
				 <h2 class="text-center">All Events</h2>
				 <div class="alert alert-info mt-2" role="alert">
				 	<button type="button" class="close"  data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
					<h5 class="text-danger">Help Text:</h5>
					<ul class="list">
						<li>Select only OR select and drag the calendar body to add new event!</li>
						<li>clicking My Events displays your events only whereas Allevents displays all events !</li>
						<li>Click the event to view its details! Then join, interest or edit event from the detail popover</li>
						<li>Color notation of different event types are <span class="badge text-white" style="background-color: #7F0180">Study</span>, <span class="badge text-white" style="background-color:#007F00"> Entertainment</span> , <span class="badge text-white" style="background-color: #d50000">miscellanous</span> and <span class="badge text-white" style="background-color: #707070">Expired</span></li>
					</ul>
				  
				</div>
					
			</div>		
		</div>


<div class="container">
<!--conatiner outer wapper-->	

<div class="row mr-0 ml-0">
	
	<div class="col-md-12 ">
		
		<input type="hidden" id="all_or_my_events_hidden" value="all">
		

		<!-- modal for addning new event-->
		<div class="modal " id="add-Event-Modal" tabindex="-1" role="dialog" aria-labelledby="add-event-modal" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="eadd-Event-Modal-Label">Add New Event</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		       <form method="POST" action="{{route('user.events.store')}}" id="add-event-form">
		       	{{csrf_field()}}
		      <div class="modal-body">
		      		<div class="form-group">
			          <small class="text-danger help_text"></small>
			        </div>
		       		 <input type="hidden" name="_method" value="POST">
		        
			        <div class="form-group">
			           <label for="add-event-title" class="col-form-label">Title:</label>
			           <input type="text" name="title" minlength="2" maxlength="191" required class="form-control" id="add-event-title">
			        </div>
			        <div class="form-group">
			            <label for="add-event-type" class="col-form-label">Type:</label>
			            <select name="type" required class="form-control" id="add-event-type">
							<option value="study">study</option>
							<option value="entertainment">entertainment</option>
							<option value="miscellaneous">miscellaneous</option>
						</select>
			        </div>
			        <div class="form-group">
			           <label for="add-event-venue" class="col-form-label">Venue:</label>
			           <input type="text" name="venue" minlength="2" maxlength="191" required class="form-control" id="add-event-venue">
			        </div>
			        <div class="row form-group">
			        	<div class="col-md-11">
			        		<label for="add-event-start-date" class="col-form-label">Start DateTime</label>
			        	</div>
			        	<div class="col-sm-6">			        		
					        <input type="date" name="start_date" min="{{ now()->toDateString() }}" required class="form-control" id="add-event-start-date" >
					           
			        	</div>
			        	<div class="col-sm-6">
			        		<input type="time" name="start_time" required  class="form-control" id="add-event-start-time">
			        	</div>
			        </div>
			        
			        <div class="row form-group">
			        	<div class="col-md-11">
			        		<label for="add-event-end-date" class="col-form-label">End DateTime</label>
			        	</div>
			        	<div class="col-sm-6">			        		
					           <input type="date" name="end_date" min="{{ now()->toDateString() }}" required class="form-control" id="add-event-end-date">
			        	</div>
			        	<div class="col-sm-6">
			        		<input type="time" name="end_time" required  class="form-control" id="add-event-end-time">
			        	</div>
			        </div>
			         <div class="form-group">
			           <label for="add-event-max-members" class="col-form-label">Max No Of Members:</label>
			           <input type="number" name="max_members" minlength="2" maxlength="5000" required class="form-control" id="add-event-max-members">
			        </div>
			        <div class="form-group">
			           <label for="add-event-description" class="col-form-label">Description:</label>
			           <textarea name="description" required class="form-control" id="add-event-description" maxlength="4000" rows="7"></textarea>	
			           <hr>
			        </div>


			    
			     @if(Auth::user()->hasPermission('create-invites'))    
			        <div class="container">
			        	<center><h4><I>INVITE USERS</I></h4></center>
			        </div>

			        <!--Notify start-->
			        <div class="form-check">
                      <input class="form-check-input" type="checkbox"  id="group_notify_checkbox" checked>
                      <label class="form-check-label" for="group_notify_checkbox">
                        Group
                      </label>
                    </div>
                  <table class="table-no-bordered p-3" id="notify_table">
                  <thead >
                    <tr  >
                      <th scope="col" width="40%">Roll No range</th>                                             
                      <th scope="col">Faculty </th>
                      <th scope="col">Year</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr >
                      <th scope="row">
                        <div class="row">
                          <div class="col-sm-5 ">
                            <input type="number" name="start_rollno[]" class="start_rollno form-control form-control-sm" min="1" max="400" required>
                          </div>
                          <div class="col-sm-1">
                            ~
                          </div>
                          <div class="col-sm-5">
                            <input type="number" name="end_rollno[]" class="end_rollno form-control form-control-sm" min="1" max="400" required>
                          </div>
                        </div>
                      </th>
                      <td><select class="form-control form-control-sm" name="facultyn[]" required="">
                        <option value="All">All</option>
                        @foreach(App\Faculty::all() as  $faculty)
                        <option value="{{$faculty->id}}">{{$faculty->name}}</option>
                       @endforeach
                      </select></td>
                      <td>
                        <select class="form-control form-control-sm" name="year[]" required>
                          @for($i=2065; $i<=2090; $i++) 
                            <option value="{{$i}}" @if($i==2071) {{'selected'}} @endif>{{$i}}</option>
                          @endfor
                      </select>
                      </td>
                      <td>
                        <input type="button" class="btn btn-sm ml-2" id="add_row_notify" value="+">
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="form-group mt-3" >
                 <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="individual" id="individual_notify_checkbox">
                    <label class="form-check-label" for="individual_notify_checkbox">
                      Individual
                    </label>
                  </div>
                  <select class="form-control mt-2" id="notify_select" multiple="multiple" name="ind_rollno[]"  style="width: 100%;" disabled> </select>
                  <small class="form-text text-muted">
                  HINT: Type user roll no and press Space , Comma or Enter Key. Max no of user is 40. use group notification for large group of users.
                  </small>
                </div>
		       <!--Notify end-->
			@endif

		      </div>

		      <div class="modal-footer">
		        <a  href="#" class="btn btn-secondary" role="button"  data-dismiss="modal">Close</a>
		         @if( Auth::user()->hasPermission('create-invites') )
			        <input type="submit" name="submit" value="submit without notifying" class="btn btn-primary">
			        <input type="submit" name="submit" value="submit and notify" class="btn btn-primary">
			     @else
			         <input type="submit" name="submit" value="submit" class="btn btn-primary">
			     @endif    
		      </div>
		  </form>
		    </div>
		  </div>
		</div>
		

		<div class="row mt-3 mb-3">
			<div class="col-md-12 " id="calendar">
				
			</div>	
		</div>		
	</div>
</div>
<!--
<div class="col-md-4" id="test_event_box" style="display:none">
	<div class="row">
		<div class="col-md-11   bg_grey border_purple"  >
			<div class="row">
				<div class="col-md-12" style="background-color: #8498c3;" >
					<a href="#" 
					><h3 class="event_title">Entertainment</h3> </a>
				</div>
			</div> 
			<div class="row">
				<div class="col-md-12" >
					<i class="far fa-calendar-alt"></i> <span class="event_start_at">2018-05-06</span>
				</div>											

			</div>
			<div class="row">
				<div class="col-md-12" >
					<i class="far fa-calendar-alt"></i> <span class="event_end_at">2018-05-06</span>
				</div>											

			</div>
			
			<div class="row">
				<div class="col-md-12" >
					<i class="fas fa-map-marker"></i> <span class="event_venue">Hatttiban</span>
				</div>											

			</div>
			<div class="row">
				<div class="col-md-12" >
					<i class="fas fa-users"></i> <span class="event_max_members"> 4/9 </span> joined
				</div>											

			</div>
			<div class="row">
				<div class="col-md-12" >
					<i class="fas fa-user"></i>  <span class="event_user_id">creator</span>
				</div>											

			</div>

			<div class="row m-t-10 pd-2" >
				<div class="col-md-6 " >
					<button type="button" class="btn btn-info">Join</button>
				</div>
				<div class="col-md-6 " >
					<button type="button" class="btn btn-primary ">Detail</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row mr-0 ml-0">
	<div class="col-md-10 offset-md-1 mt-4 mr-0" id="events_div">
		<div class="row" >
			<div class="col-md-12 " style="background-color: #fdfdfd;" >
				<center><h2>SHOWING EVENTS FOR <span id="showing_event"></span>  </h2></center>
				<div class="row mt-3 mb-4" id="project_box" >


					
				</div>
			</div>
		</div>			
	</div>
</div>
-->
<!-- closing div of container and main-container-->
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript">
	$(document).ready( function(){

		//Notify users js start
           $('#add_row_notify').on('click', function(){ 
           	//alert($('#notify_table tbody tr').length)
              if($('#notify_table tbody tr').length < 12)
              {
                cloned_row=$('#notify_table tbody tr').first().clone()
                //console.log($('thead tr:first'))
                cloned_row.find('#add_row_notify').replaceWith( ' <input type="button" class="close_btn btn btn-sm ml-2 "  value="-">')
                cloned_row.appendTo('#notify_table tbody');
              }
            });

            $('#notify_table tbody').on('click', '.close_btn' ,function(){
              $(this).parents('tr').remove() 
         
            })
            $('#individual_notify_checkbox').on('change', function(){
              if($(this).prop('checked')==true) 
                $('#notify_select').attr('disabled', false)
              else 
                 $('#notify_select').attr('disabled', true)

            })
            $('#group_notify_checkbox').on('change', function(){
              if($(this).prop('checked')==true) 
                $('#notify_table input, #notify_table select').attr('disabled', false)
              else 
                 $('#notify_table input, #notify_table select').attr('disabled', true)

            })  
           
            $('#notify_select').select2({
                 placeholder: "EG: 044BCT2071",
                maximumSelectionLength:40,
                tags:true,
                tokenSeparators: [',',' '],
                createTag: function(param){
                     term=(param.term).trim();
                    length=term.length;

                    fchar=term.charAt(0);
                    lchar=term.charAt(length-1);

                    if(length<10 || term.indexOf(',')!== -1 || term.indexOf('\'')!== -1 || term.indexOf('\"')!== -1 || fchar==',' || fchar=='-' || fchar=='_' || lchar=='_'|| lchar=='-' || term.indexOf('@')!== -1)
                        return null;
                    else
                        return {
                          id: term,
                          text: term,
                          newTag: true 
                        }
                }
            }); 
            //Notify users end

		var calendar = $('#calendar').fullCalendar({
			themeSystem: 'bootstrap4',
			customButtons: {
			    allEvents: {
			      text: 'All Events',
			      click: function() {
			        $('#all_or_my_events_hidden').val('all');
			        $(this).addClass('active');
			        if($(this).next().hasClass('active')) $(this).next().removeClass('active');
			        calendar.fullCalendar( 'refetchEvents' );
			        //alert($('#all_or_my_events_hidden').val());
			      }
			    },
			     myEvents: {
			      text: 'My Events',
			      click: function() {
			        $('#all_or_my_events_hidden').val('my');
			        $(this).addClass('active');
			        if($(this).prev().hasClass('active')) $(this).prev().removeClass('active');
			        //$(this).button('dispose');
			        calendar.fullCalendar( 'refetchEvents' );
			        
			      }
			    }
			  },
			header:{
		    left:'allEvents, myEvents, today',
		    center:'prev, title, next',
		    right:' month,agendaWeek,agendaDay, list'
	    	},
	    	buttonText: {
        		list: "list events"
				},
	    	aspectRatio: 1.7,
	    	eventLimit : true,
	    	//events : '{{--route('user.events.feed')--}}',
	    	events: {
            url: '{{route('user.events.feed')}}',
            data: function () { // a function that returns an object
                return {
                    personId: $('#all_or_my_events_hidden').val(),
                };
            	}
            },
	    	selectable : true,
	    	selectHelper: true,
	    	select : function (start, end)
	    	{	
	    		start_date = $.fullCalendar.formatDate(start, "Y-MM-DD")
	    		end_date = $.fullCalendar.formatDate(end, "Y-MM-DD");
	    		start_time = $.fullCalendar.formatDate(start, "HH:mm");
	    		end_time =$.fullCalendar.formatDate(end, "HH:mm");
	    		//alert(start_date)
	    		$('input[name="_method"]').val('POST');
			    $('#add-event-form').attr('action', '{{route('user.events.store')}}')
	    		$('#add-event-start-date').val(start_date);	 	    				
	    		$('#add-event-start-time').val(start_time);
	    		$('#add-event-end-date').val(end_date);
	    		$('#add-event-end-time').val(end_time);

	    		$('#add-Event-Modal').modal('show');
	    	
	    	},
	    	eventRender: function(event, element){
	    		element.attr('data-toggle', 'popover');
	    		edit_disabled = '';
	    		if_expired = ''
	    		if(event.deleted_at)
	    		{
					action_btns = ['<div class="col-sm-5 " >',
											'<button type="button"  class="btn btn-outline-dark btn-block btn-sm interest_btn" value="interested" disabled>interested </button>',
										'</div>',
										'<div class="col-sm-5 " >',
											'<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="join" disabled>join</button>',
										'</div>'].join('')
					edit_disabled = 'disabled="disabled"'	
					if_expired = ' (expired)'		
	    		}
	    		else if(event.user_status == 'interested')
	    			action_btns =['<div class="col-sm-5 " >',
											'<button type="button"  class="btn btn-outline-dark btn-block btn-sm interest_btn" value="uninterested"><i class="fas fa-check"></i> interested </button>',
										'</div>',
										'<div class="col-sm-5 " >',
											'<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="join">join</button>',
										'</div>'].join('')

				else if(event.user_status == 'joined')						
					action_btns =['<div class="col-sm-5 " >',
											'<button type="button"  class="btn btn-outline-dark btn-block btn-sm interest_btn" value="interested" disabled="disabled"> interested </button>',
										'</div>',
										'<div class="col-sm-5 " >',
											'<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="unjoin"><i class="fas fa-check"></i> joined</button>',
										'</div>'].join('')
				else if(event.user_status == null)						
					action_btns = ['<div class="col-sm-5 " >',
											'<button type="button"  class="btn btn-outline-dark btn-block btn-sm interest_btn" value="interested">interested </button>',
										'</div>',
										'<div class="col-sm-5 " >',
											'<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="join">join</button>',
										'</div>'].join('')
					

				if(event.editable == true )						
					edit_btn = '<button type="button" class="btn btn-secondary btn-block btn-sm" '+edit_disabled+' value="edit"><i class="fas fa-edit" ></i></button>';
				else 
					edit_btn=''

	    		   element.popover({
	    		   		container: 'body',
				        placement: 'auto',
				       
				        html: true,
				        
				        title : '<div class="row"><div class="col-md-10" ><a href="{{url('/').'/user/events/'}}'+event.id+'"><span class="event_title">'+event.title+if_expired+'</span></a></div> <div class="col-md-2"> <button type="button"  class="clos close" >&times;</button> </div></div>',
				        trigger: 'click',
				        boundary: 'viewport',
				        content : [
							'<div class="row" >',
								'<div class="col-md-11"  >',
									'<div class="row ">',
									'<div class="col-sm-1 ">',
										'<i class="far fa-calendar-alt"></i>',
									'</div>',
									'<div class="col-sm-10 ">', 
										'<div class="row">',
											'<div class="col-sm-12" >',
												' <span class="event_start_at">'+moment(event.start).format("MMMM Do YYYY, h:mm a")+'</span>',
											'</div>                                                                               </div>',
										'<div class="row">',
											'<div class="col-sm-12" >',
												'</i> <span class="event_end_at">'+moment(event.end).format("MMMM Do YYYY, h:mm a")+'</span>',
											'</div>                                                                                </div>',
									'</div></div>',	
									'<div class="row ">',
									'<div class="col-sm-1 ">',
										'<i class="fas fa-map-marker"></i> ',
									'</div>',
									'<div class="col-sm-10 ">',
									'<div class="row">',
										'<div class="col-md-12" >',
											'<span class="event_venue">'+event.venue+'</span>',
										'</div></div>',
										'</div></div>',	
									'<div class="row ">',
									'<div class="col-sm-1 ">',
										'<i class="fas fa-users"></i>',
									'</div>',
									'<div class="col-sm-10 ">',	
									'<div class="row">',
										'<div class="col-md-12" >',
											' <span class="event_max_members"> '+event.members_joined+' </span> joined',
									'</div></div>',
									'</div></div>',	

									'<div class="row ">',
									'<div class="col-sm-1 ">',
										'<i class="fas fa-user"></i>',
									'</div>',
									'<div class="col-sm-10 ">',
									'<div class="row">',
										'<div class="col-sm-12" >',
											'  <span class="event_user_id">'+event.owner+'</span>',
									'</div></div>',
									'</div></div>',
									'<div class="row mt-2 pd-2" >',
										action_btns ,

										'<div class="col-sm-2 " >',
											
											edit_btn,
										'</div>',
									'</div>',

								'<input type="hidden" value="'+event.id+'"></div>',
							'</div>'
						].join(''),
				        
			   		 })
			   		

	    		$('body').on('click', function (e) {
                    if (!element.is(e.target) && element.has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
                        element.popover('hide');

                });

	    		$(document).on('click', '.popover-header .clos', function(){
					//element.popover('hide');
					$('.popover').popover('hide')
					/*$("[data-toggle=popover]").each(function(i){
						$(this).popover('hide')
						});*/
				});

			
	    	},
	    	
	    	eventAfterAllRender : function(){
	    		retrieved_event=calendar.fullCalendar('clientEvents');
						console.log(retrieved_event)

	    		
	    	},

	   
		});

		//activating custom 'All Events' button at header of calendar on loading of the page
		$('.fc-allEvents-button').addClass('active');
		
		$(document).on('click', '.popover-body button', function(){
					var action = $(this).val(); 
					id = $(this).parent().parent().next().val();
					var thisBtn= $(this);
					//alert(action+'  '+id);
					if(action != 'edit')
					{		

						url='{{route('user.events.action')}}';
								
						 $.ajax({
			                	type :'GET',
			                    url : url,
			                   
			                    data:{	'token' : '{{csrf_token()}}',
			                    	'action' : action,
					                   'id' : id
								 },

								success : function(data1)
								{
									console.log(data1);
									if(action == 'join')
									{
										thisBtn.html('<i class="fas fa-check"></i> joined')
										thisBtn.val('unjoin')

										thisBtn.parent().parent().find('.interest_btn').html('interested');
										thisBtn.parent().parent().find('.interest_btn').val('interested');
										thisBtn.parent().parent().find('.interest_btn').attr('disabled', 'disabled');

									} 
									else
									if(action == 'interested')
									{
										thisBtn.html('<i class="fas fa-check"></i> interested')
										thisBtn.val('uninterested')
									}else
									if(action == 'unjoin')
									{
										thisBtn.html('join')
										thisBtn.val('join')
										thisBtn.parent().parent().find('.interest_btn').attr('disabled', false);

										
									}else
									if(action == 'uninterested')
									{
										thisBtn.html('interested')
										thisBtn.val('interested')
									}
									//$('[data-toggle="popover"]').popover('hide')
									 calendar.fullCalendar('refetchEvents') 
									 
									/*$('[data-toggle="popover"]').on('hidden.bs.popover', function () {
  											
									});*/
								},
								error : function(data2)
								{
									console.log(data2);
								}		
						});	
					} else
					{
						retrieved_event=calendar.fullCalendar('clientEvents', id);
/*						
						start_date = $.fullCalendar.formatDate(start, "Y-MM-DD")
	    		end_date = $.fullCalendar.formatDate(end, "Y-MM-DD");
	    		start_time = $.fullCalendar.formatDate(start, "HH:mm");
	    		end_time =$.fullCalendar.formatDate(end, "HH:mm");*/
	    				//alert(retrieved_event[0].title+' '+$.fullCalendar.formatDate(retrieved_event[0].start, "Y-MM-DD"))
			    		$('#add-Event-Modal').modal('show');
			    		//console.log(retrieved_event[0].title+retrieved_event[0].type)
			    		$('input[name="_method"]').val('PUT');
			    		$('#add-event-form').attr('action', '{{url('/')}}'+'/user/events/'+id) 
			    		
						$('#add-event-title').val(retrieved_event[0].title);
						$('#add-event-type').val(retrieved_event[0].type);
						$('#add-event-venue').val(retrieved_event[0].venue);
						$('#add-event-start-date').val((retrieved_event[0].start).format("YYYY-MM-DD"));
						$('#add-event-start-time').val( (retrieved_event[0].start).format("HH:mm"));
						$('#add-event-end-date').val((retrieved_event[0].end).format("YYYY-MM-DD"));
						$('#add-event-end-time').val((retrieved_event[0].end).format("HH:mm"));
						$('#add-event-max-members').val((retrieved_event[0].members_joined).split('/')[1]);
						$('#add-event-description').val(retrieved_event[0].description);
						//moment(retrieved_event.start).format("HH:mm")
					}

					
				});	

	    		//
				$( "#add-event-form" ).submit(function( event )
	         		{
		    		 start_dateTime = moment($('#add-event-start-date').val()+' '+$('#add-event-start-time').val());
		    		 end_dateTime = moment($('#add-event-end-date').val()+' '+$('#add-event-end-time').val());
		    		 if(start_dateTime > end_dateTime)
		    		 {
		    		 	$('.help_text').text('Error :End dateTime should be greater than start dateTime');
		    		 	return false;
		    		 }
		    		 			
		    		 	else return true;	
		    		 	
		    		});
		
		
		
	});
</script>
@endsection