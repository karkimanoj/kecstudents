@extends('layouts.manage')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>
     /* tinymce.init({ selector:'textarea',
              menubar:'false',
              plugins:'code link' });  */
  </script>

@endsection

@section('content')
<div class="main-container">
    

    <div class="row ">
        <div class="col-md-11 offset-md-1 ">
        	<h2><center>UPLOAD NEW event</center></h2>
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" action="{{route('events.store')}}" id="add-event-form">
                                {{csrf_field()}}    
                                        
                                <div class="row form-group m-t-20{{ $errors->has('title')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                       <label for="add-event-title" class="col-form-label">Title:</label>
                                    </div>    
                                     <div class="col-md-8">
                                          
                                           <input type="text" name="title" minlength="2" maxlength="191" required class="form-control" id="add-event-title" value="{{old('title')}}">

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
                                    <div class="col-md-8">
                                      
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
                                         
                                         <input type="text" name="venue" minlength="2" maxlength="191" required class="form-control" id="add-event-venue" value="{{old('venue')}}">
                                       
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
                                    <input type="date" name="start_date" min="{{ now()->toDateString() }}" required class="form-control" id="add-event-start-date" value="{{old('start_date')}}">
                                       
                                  </div>
                                  <div class="col-sm-4">
                                    <input type="time" name="start_time" required  class="form-control" id="add-event-start-time" value="{{old('start_time')}}">
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
                                    <input type="date" name="end_date" min="{{ now()->toDateString() }}" required class="form-control" id="add-event-end-date" value="{{old('end_date')}}">
                                       
                                  </div>
                                  <div class="col-sm-4">
                                    <input type="time" name="end_time" required  class="form-control" id="add-event-end-time" value="{{old('end_time')}}">
                                  </div>
                                  <div class="col">
                                    <span class="help-block">
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
                                         
                                        <input type="number" name="max_members" minlength="2" maxlength="5000" required class="form-control" id="add-event-max-members" value="{{old('max_members')}}">
                                       
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
                                         
                                         <textarea name="description" required class="form-control" id="add-event-description" maxlength="4000" rows="7">{{old('description')}}</textarea>
                                       
                                        <span class="help-block">
                                            @if($errors->has('description'))
                                                <strong>{{ $errors->first('description') }}</strong>
                                                
                                            @endif
                                        </span>
                                        
                                     </div>                 
                                </div>

                                <div class="container">
                                  <center><h4><I>INVITE USERS</I></h4></center>
                                </div>
                                <!--Notify start-->
                              <div class="row">
                                <div class="col-md-8 offset-md-3">

                                   

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

                                <div class="row form-group mt-3">
                                    <div class="col-md-8 offset-md-3"> 
                                      <!-- <center><input type="submit" name="submit" value="submit" class="btn btn-primary"></center>-->
                                       <input type="submit" name="submit" value="submit without notifying" class="btn btn-primary">
                                      <input type="submit" name="submit" value="submit and notify" class="btn btn-primary">
                                    </div>
                                </div>

                              </div>
                            </div>


                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript">

  $(document).ready(function(){

        $('#add_row_notify').on('click', function(){
          if($('tbody tr').length < 12)
          {
            cloned_row=$('tbody tr').first().clone()
            //console.log($('thead tr:first'))
            cloned_row.find('#add_row_notify').replaceWith( ' <input type="button" class="close_btn btn btn-sm ml-2 "  value="-">')
            cloned_row.appendTo('tbody');
          }
        });

        $('#post-form').on('click', '.close_btn' ,function(){
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
        }); //end of select 2
    
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