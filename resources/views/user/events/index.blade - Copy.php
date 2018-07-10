@extends('layouts.app')

@section('content')
<div class="row mr-0 ml-0">
	<div class="col-md-10 offset-md-1">
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
			        		<label for="add-event-type" class="col-form-label">Start DateTime</label>
			        	</div>
			        	<div class="col-sm-6">			        		
					        <input type="date" name="start_date" min="{{ now()->toDateString() }}" required class="form-control" id="add-event-start-date" value="2018-05-06">
					           
			        	</div>
			        	<div class="col-sm-6">
			        		<input type="time" name="start_time" required  class="form-control" id="add-event-start-time">
			        	</div>
			        </div>
			        
			        <div class="row form-group">
			        	<div class="col-md-11">
			        		<label for="add-event-type" class="col-form-label">End DateTime</label>
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
			        </div>
		       
		      </div>

		      <div class="modal-footer">
		        <a  href="#" class="btn btn-secondary" role="button"  data-dismiss="modal">Close</a>
		        
		        <input type="submit" value="submit" class="btn btn-primary">
		      </div>
		  </form>
		    </div>
		  </div>
		</div>
		<!--end of modal-->

		<div class="row mt-3">
			<div class="col-md-12 " id="calendar">
				
			</div>	
		</div>		
	</div>
</div>

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

@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready( function(){

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

/*
	    		$("#add-event-max-members ").on('change', function (){
			        alert(moment($('#add-event-start-date').val()+' '+$('#add-event-start-time').val() ))
			    });*/
	    		
	    		
	    		


	    		/*
	    		var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      			var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      			
      			$.ajax({
      				type:'GET',
                    url : '{{--route('user.events.eventList')--}}',
                    dataType:'JSON',
                    data:{ 'start' : start,
		                   'end' : end,
					 },

					success : function(data1){
						console.log(data1);

						var host='{{--url('/')--}}';
						$('#project_box').empty();

						for(i=0; i < data1.length; i++)
						{	
							eventg = data1[i];

							$cloned = $( "#test_event_box" ).clone(true, true)
							$cloned.find(".event_title").html('<a href="'+host+'/user/events/'+eventg.id+'">'+eventg.title+'</a>')
							$cloned.find(".event_venue").text(eventg.venue)
							$cloned.find(".event_start_at").text(moment(eventg.start_at).format('MMMM Do YYYY, h:mm a'))
							$cloned.find(".event_end_at").text(moment(eventg.end_at).format('MMMM Do YYYY, h:mm a'))
							$cloned.find(".event_max_members").text(eventg.event1_members_count)
							$cloned.find(".event_user_id").text(eventg.user.name)
							$cloned.show()
							$cloned.appendTo("#project_box")
							$("#showing_event").text( moment(start).format('MMMM Do YYYY')+' - '+  moment(end).format('MMMM Do YYYY'));
							$(document).scrollTop( ($('#events_div').offset().top)-80 );
							
						}
						
					} 
                 });     $(&quot;#example&quot;)*/
	    	},
	    	eventRender: function(event, element){
	    		element.attr('data-toggle', 'popover');

	    		if(event.user_status == 'interested')
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
											'<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="join"><i class="fas fa-check"></i> joined</button>',
										'</div>'].join('')
				else if(event.user_status == null)						
					action_btns = ['<div class="col-sm-5 " >',
											'<button type="button"  class="btn btn-outline-dark btn-block btn-sm interest_btn" value="interested">interested </button>',
										'</div>',
										'<div class="col-sm-5 " >',
											'<button type="button" class="btn btn-outline-info btn-block btn-sm  join_btn" value="join">join</button>',
										'</div>'].join('')
				if(event.editable == true)						
					edit_btn = '<button type="button" class="btn btn-secondary btn-block btn-sm" value="edit"><i class="fas fa-edit"></i></button>';
				else 
					edit_btn=''

	    		   element.popover({
	    		   		container: 'body',
				        placement: 'auto',
				        html: true,
				        
				        title : '<div class="row"><div class="col-md-10" ><a href="{{route('user.events.create')}}"><span class="event_title">'+event.title+'</span></a></div> <div class="col-md-2"> <button type="button"  class="clos close" >&times;</button> </div></div>',
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
					element.popover('hide');
					$("[data-toggle=popover]").each(function(i){
						$(this).popover('hide')
						});
				});

			
	    	},
	    	
	    	eventAfterAllRender : function(){
	    		retrieved_event=calendar.fullCalendar('clientEvents');
						console.log(retrieved_event)

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
									//console.log(data1);
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
	    				
			    		$('#add-Event-Modal').modal('show');
			    		//console.log(retrieved_event[0].title+retrieved_event[0].type)
			    		$('input[name="_method"]').val('PUT');
			    		$('#add-event-form').attr('action', '{{url('/')}}'+'/user/events/'+id) 
			    		
						$('#add-event-title').val(retrieved_event[0].title);
						$('#add-event-type').val(retrieved_event[0].type);
						$('#add-event-venue').val(retrieved_event[0].venue);
						$('#dd-event-start-date').val(moment(retrieved_event[0].start).format("YYYY-MM-DD"));
						$('#add-event-start-time').val( moment(retrieved_event[0].start).format("HH:mm"));
						$('#add-event-end-date').val(moment(retrieved_event[0].end).format("YYYY-MM-DD"));
						$('#add-event-end-time').val(moment(retrieved_event[0].end).format("HH:mm"));
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
	    	},

	   
		});

		//activating custom 'All Events' button at header of calendar on loading of the page
		$('.fc-allEvents-button').addClass('active');
		
		
		
	});
</script>
@endsection