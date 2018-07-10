@extends('layouts.manage')




@section('content')
<div class="main-container">
    

    <div class="row ">
        <div class="col-md-11 offset-md-1 ">
          <h2><center>UPLOAD NEW EVENT</center></h2>
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                      <form method="POST" action="{{route('events.update', $event->id)}}" id="edit-event-form">
                              {{csrf_field()}}    
                              {{method_field('PUT')}}       
                              <div class="row form-group m-t-20{{ $errors->has('title')?'has-error':'' }} ">
                                  <div class="col-md-3">    
                                     <label for="add-event-title" class="col-form-label">Title:</label>
                                  </div>    
                                   <div class="col-md-8">
                                        
                                         <input type="text" name="title" minlength="2" maxlength="191" required class="form-control" id="add-event-title" value="{{$event->title or old('title') }}">

                                      @if($errors->has('title'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('title') }}</strong>
                                          </span>
                                      @endif
                                   </div>                 
                              </div>

                              <div class=" row form-group m-t-20" id="subject_div">
                                  <div class="col-md-3">               
                                  <label for="add-event-type" class="col-form-label">Type:</label>
                                  </div>
                                  <div class="col-md-8" >
                                    
                                     <select name="type" required class="form-control" id="add-event-type">
                                      <option value="study">study</option>
                                      <option value="entertainment">entertainment</option>
                                      <option value="miscellaneous">miscellaneous</option>
                                    </select>
                                  </div>
                              </div>

                              <div class="row form-group m-t-20{{ $errors->has('venue')?'has-error':'' }} ">
                                  <div class="col-md-3">    
                                      <label for="add-event-venue" class="col-form-label mr-2">Venue:</label>
                                  </div>    
                                   <div class="col-md-8">
                                       
                                       <input type="text" name="venue" minlength="2" maxlength="191" required class="form-control" id="add-event-venue" value="{{$event->venue or old('venue')}}">
                                     
                                      <span class="help-block">
                                          @if($errors->has('venue'))
                                              <strong>{{ $errors->first('venue') }}</strong>
                                              
                                          @endif
                                      </span>
                                      
                                   </div>                 
                              </div>

                              <div class="row form-group mt-2 {{ ($errors->has('start_date') || $errors->has('start_time'))?'has-error':'' }} ">
                                <div class="col-md-3">
                                  <label for="add-event-start-date" class="col-form-label">Start DateTime</label>
                                </div>
                                <div class="col-sm-4">                  
                                  <input type="date" name="start_date" min="{{ now()->toDateString() }}" required class="form-control" id="add-event-start-date" value="{{$event->start_date or old('start_date')}}">
                                     
                                </div>
                                <div class="col-sm-4">
                                  <input type="time" name="start_time" required  class="form-control" id="add-event-start-time" value="{{$event->start_time or old('start_time')}}">
                                </div>
                                <div class="col">
                                  <span class="help-block">
                                          @if($errors->has('start_date'))
                                              <strong>{{ $errors->first('start_date') }}</strong>
                                              
                                          @endif
                                          @if($errors->has('start_time'))
                                              <strong>{{ $errors->first('start_time') }}</strong>
                                              
                                          @endif
                                      </span>
                                </div>
                              </div>

                              <div class="row form-group mt-2 {{ ($errors->has('end_date') || $errors->has('end_time'))?'has-error':'' }} ">
                                <div class="col-md-3">
                                  <label for="dd-event-end-date" class="col-form-label">End DateTime</label>
                                </div>
                                <div class="col-sm-4">                  
                                  <input type="date" name="end_date" min="{{ now()->toDateString() }}" required class="form-control" id="add-event-end-date" value="{{$event->end_date or old('end_date')}}">
                                     
                                </div>
                                <div class="col-sm-4">
                                  <input type="time" name="end_time" required  class="form-control" id="add-event-end-time" value="{{$event->end_time or old('end_time')}}">
                                </div>
                                <div class="col">
                                  <span class="help-block text-danger" id="end_date_help_block">
                                          @if($errors->has('end_date'))
                                              <strong>{{ $errors->first('end_date') }}</strong>
                                              
                                          @endif
                                          @if($errors->has('end_time'))
                                              <strong>{{ $errors->first('end_time') }}</strong>
                                              
                                          @endif
                                      </span>
                                </div>
                              </div>

                              <div class="row form-group m-t-20{{ $errors->has('max_members')?'has-error':'' }} ">
                                  <div class="col-md-3">    
                                      <label for="add-event-max-members" class="col-form-label mr-2">Max Members:</label>
                                  </div>    
                                   <div class="col-md-8">
                                       
                                      <input type="number" name="max_members" minlength="2" maxlength="5000" required class="form-control" id="add-event-max-members" value="{{$event->max_members or old('max_members')}}">
                                     
                                      <span class="help-block">
                                          @if($errors->has('max_members'))
                                              <strong>{{ $errors->first('max_members') }}</strong>
                                              
                                          @endif
                                      </span>
                                      
                                   </div>                 
                              </div>
                              <div class="row form-group m-t-20{{ $errors->has('description')?'has-error':'' }} ">
                                  <div class="col-md-3">    
                                      <label for="add-event-description" class="col-form-label mr-2">description:</label>
                                  </div>    
                                   <div class="col-md-8">
                                       
                                       <textarea name="description" required class="form-control" id="add-event-description" maxlength="4000" rows="7">{{$event->description or old('description')}}</textarea>
                                     
                                      <span class="help-block">
                                          @if($errors->has('description'))
                                              <strong>{{ $errors->first('description') }}</strong>
                                              
                                          @endif
                                      </span>
                                      
                                   </div>                 
                              </div>
                              <div class="row form-group mt-3">
                                  <div class="col-md-8 offset-md-3"> 
                                     <center><input type="submit" name="submit" value="submit" class="btn btn-primary"></center>
                                  </div>
                              </div>    
       
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')


  <script type="text/javascript">

      $(document).ready(function(){

    $('#add-event-type').val('{{trim($event->type)}}');

$( "#edit-event-form" ).submit(function( event )
              {
             start_dateTime = moment($('#add-event-start-date').val()+' '+$('#add-event-start-time').val());
             end_dateTime = moment($('#add-event-end-date').val()+' '+$('#add-event-end-time').val());
             if(start_dateTime > end_dateTime)
             {
              $('#end_date_help_block').text('Error :End dateTime should be greater than start dateTime');
              return false;
             }
                  
              else return true; 
              
            });

        

      });
  </script>

@endsection