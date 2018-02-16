@extends('layouts.manage')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-11 col-md-offset-1 ">
        	<h2><center>Edit project</center></h2>
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" action="{{route('projects.update', $project->id)}} " enctype="multipart/form-data">
                        		{{method_field('PUT')}}
                                {{csrf_field()}}    
                                        
                                <div class="row form-group m-t-20{{ $errors->has('name')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">Name of the project:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <input type="text" name="name" minlength="4" class="form-control" value="{{$project->name or old('name')}}" required maxlength="255">

                                        @if($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                     </div>                 
                                </div>

                                <div class=" row form-group m-t-20" id="subject_div">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">project category</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{$project->subject->name}}
                                    </div>
                                </div>

                                <div class="row form-group m-t-20{{ $errors->has('abstract')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">Abstract:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <textarea class="form-control" required rows="14" name="abstract" >{{ $project->abstract or old('abstract')}}</textarea>
                                       
                                            <span class="help-block" >
                                                 @if($errors->has('abstract'))
                                                <strong>{{ $errors->first('abstract') }}</strong>
                                                @else
                                                <small class="form-text text-muted">hint: you can copy and paste abstract from your project documentation file</small>
                                                @endif
                                            </span>
                                        
                                     </div>                 
                                </div>
                                <div class=" row form-group m-t-20" >
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">tags:</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" id="tag_select" multiple="multiple" name="tags[]" required> 

                                        </select>
                                        <small class="form-text text-muted">
                                        select up to 20 tags. you can create your own tag by typing the tagname and hitting enter.
                                        </small>
                                    </div>
                                </div>

                                <div class="row form-group m-t-20{{ $errors->has('link')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">github link:</label>
                                    </div>    
                                     <div class="col-md-8">
                                        <div class="input-group">
                                             <span class="input-group-btn" id="basic-addon2">
                                              <button class="btn btn-default">
                                                  <i class="fas fa-link" style="color:#228AE6"></i>
                                                </button> 
                                              </span>
                                              <input type="url" name="link" class="form-control" value="{{$project->url_link or old('link')}}" aria-describedby="basic-addon2" maxlength="255" >
                                        </div>  

                                         <span class="help-block">
                                                @if($errors->has('link'))
                                                  <strong>{{ $errors->first('link') }}</strong>
                                                @else
                                                    <small class="form-text text-muted">Example: https://github.com/karkimanoj/kecstudents</small>
                                                @endif
                                            </span>
                                     </div>                 
                                </div>

                                <div class=" row form-group m-t-20">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">file: </label>
                                    </div>
                                    <div class="col-md-8">
                                        {{$project->original_filename}}
                                    </div>
                                </div>

                                <div class="row m-t-20">
                                    <div class="col-md-3">
                                         <label class="m-t-20">project members ( max 6):</label> 
                                    </div>
                                     <div class="col-md-8">
                                         <label class=" m-t-20 m-l-20"><span class="form-text text-muted">Hint: tick checkbox to add members</span> </label> 
                                    </div>
                                     
                                </div>
                                           
                               
                                 @foreach($project->project_members as $member)
                                 	 <div class="row form-group m-t-20 ">
                                    @if( Auth::user()->roll_no==$member->rollno )
                                         <div class="col-md-3 col-md-offset-3" style="display: none;">
                                            <input type="checkbox" class="pull-left" style="width: 15%" >
                                            
                                             <input type="hidden" style="width: 85%" name="member_rollno[]"  class="form-control pull-right" value="{{Auth::user()->roll_no}}" required maxlength="15" placeholder="roll no">

                                            @if($errors->has('member_rollno[]'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('member_rollno[]') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                        <div class="col-md-5">
                                             <input type="hidden" name="member_name[]" minlength="4" class="form-control" value="{{Auth::user()->name}}" required maxlength="255" placeholder="name">

                                            @if($errors->has('member_name[]'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('member_name[]') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                  
                                    @else
                                    	<div class="col-md-3 col-md-offset-3">
		                                        
		                                        <input type="checkbox" class="pull-left" style="width: 15%" checked>
		                                        
		                                         <input type="text" style="width: 85%" name="member_rollno[]"  class="form-control pull-right" value="{{$member->roll_no or old('member_rollno[]')}}" required maxlength="15" placeholder="roll no">

		                                        @if($errors->has('member_rollno[]'))
		                                            <span class="help-block">
		                                                <strong>{{ $errors->first('member_rollno[]') }}</strong>
		                                            </span>
		                                        @endif
		                                     </div> 
		                                     <div class="col-md-5">
		                                         <input type="text" name="member_name[]" minlength="4" class="form-control" value="{{$member->name or old('member_name[]')}}" required maxlength="255" placeholder="name">

		                                        @if($errors->has('member_name[]'))
		                                            <span class="help-block">
		                                                <strong>{{ $errors->first('member_name[]') }}</strong>
		                                            </span>
		                                        @endif
		                                     </div> 
		                                @endif                    
                                </div>
                                        
                                @endforeach

                                @for($i=count($project->project_members); $i<5; $i++)
                                  <div class="row form-group m-t-20 ">
                                	<div class="col-md-3 col-md-offset-3">
		                                        
                                        <input type="checkbox" class="pull-left" style="width: 15%" >
                                        
                                         <input type="text" style="width: 85%" name="member_rollno[]"  class="form-control pull-right" value="{{ old('member_rollno[]')}}" required maxlength="15" placeholder="roll no">

                                        @if($errors->has('member_rollno[]'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('member_rollno[]') }}</strong>
                                            </span>
                                        @endif
                                     </div> 
                                     <div class="col-md-5">
                                         <input type="text" name="member_name[]" minlength="4" class="form-control" value="{{old('member_name[]')}}" required maxlength="255" placeholder="name">

                                        @if($errors->has('member_name[]'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('member_name[]') }}</strong>
                                            </span>
                                        @endif
                                     </div> 
                                    </div> 
                                @endfor

                                

                                
                                        <center><input type="submit" name="upload" value="upload" class="btn btn-primary"></center>
                                
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


         //select 2 tag[] part  start 
        var data = [@foreach($tags as $tag)
            {
                id: {{$tag->id}},
                text: '{{$tag->name}}'
            },

            @endforeach];

        $('#tag_select').select2({
            data:data,
            maximumSelectionLength:20,
            tags:true,
            tokenSeparators: [',',' '],
            createTag: function(param){
                var term=(param.term).trim();
                length=term.length;

                fchar=term.charAt(0);
                lchar=term.charAt(length-1);

                if(length<2 || term.indexOf(',')!== -1 || term.indexOf('\'')!== -1 || term.indexOf('\"')!== -1 || fchar==',' || fchar=='-' || fchar=='_' || lchar=='_'|| lchar=='-' || term.indexOf('@')!== -1)
                    return null;
                else
                    return {
                      id: '@'+term,
                      text: term,
                      newTag: true 
                    }
            }
        }); //end of select 2

        $selected_tags=[ @foreach($project->tags as $selected_tag)
        					{{$selected_tag->id}},
       					 @endforeach
        ];
        	 $('#tag_select').val($selected_tags);

            //activiting the project members field

            function add_members($this){
                $name_input=$this.parent().next().children('input');
                if($this.prop('checked'))
                {       //alert('aaaaaaaaa');
                    $this.next().prop('disabled', false);
                    $name_input.prop('disabled', false);
                } else{
                     $this.next().prop('disabled', true);
                     $name_input.prop('disabled', true);
                 }
            }

            $.each($("input[type=checkbox]"), function() {
                add_members($(this));
            });

            $('input[type=checkbox]').change(function (){

                add_members($(this));

            });

      });
  </script>
@endsection