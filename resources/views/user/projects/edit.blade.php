@extends('layouts.app')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
      tinymce.init({ selector:'textarea',
              menubar:'false',
              plugins:'code link' });
  </script>

@endsection

@section('content')
<div class="main-container">
    <div class="container-fluid" id="top_header" >
          <h2 class="text-center">Edit project</h2>
    </div>

  <div class="container">   
    <div class="row ">
        <div class="col-md-9 bg-white mb-3 ">
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" id="projectEditForm" action="{{route('user.projects.update', $project->id)}} " enctype="multipart/form-data">
                        		{{method_field('PUT')}}
                                {{csrf_field()}}    
                                        
                                <div class="row form-group m-t-20{{ $errors->has('name')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="float-right m-r-20">Name of the project:</label>
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
                                       <label class="float-right m-r-20">project category</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{$project->subject->name}}
                                    </div>
                                </div>

                                <div class="row form-group m-t-20{{ $errors->has('abstract')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="float-right m-r-20">Abstract:</label>
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
                                       <label class="float-right m-r-20">tags:</label>
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
                                        <label class="float-right m-r-20">github link:</label>
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
                                       <label class="float-right m-r-20">file: </label>
                                    </div>
                                    <div class="col-md-8">
                                        {{$project->original_filename}}
                                    </div>
                                </div>

                                <div class=" row form-group m-t-20 ">
                                    <div class="col-md-3" >               
                                       <label class="float-right m-r-20" >screenshots/photos
                                       </label>
                                    </div>

                                    <div class="col-md-9">
                                        @foreach($project->imgs as $image)
                                          <img src="{{asset($image->filepath)}}" width="46%" style="margin-left:3%">
                                        @endforeach
                                    </div>
                                </div>

                                 <div class=" row form-group mt-2 {{ $errors->has('images')?'has-error':'' }}">
                                    <div class="col-md-8 offset-md-3">
                                        <input type="file" name="images[]" multiple class="form-control" accept="image/*"   >
                                        @if($errors->has('images'))
                                        <strong>{{ $errors->first('images') }}</strong>
                                        @else
                                        <small class="form-text text-muted">
                                        selecting new images will replace previous images, leave empty to keep current images. max 2. image format: jpeg, png, gif
                                        </small>
                                        @endif
                                    </div>
                                </div>
                           
                                <div class="row m-t-20">
                                    <div class="col-md-3">
                                         <label class="m-t-20 float-right">members (max 6):</label> 
                                    </div>
                                     <div class="col-md-8">
                                         <label class=" m-t-20 m-l-20"><span class="form-text text-muted">Hint: tick checkbox to add members</span> </label> 
                                    </div>
                                     
                                </div>
                                           
                               
                                 @foreach($project->project_members()->withTrashed()->get() as $member)
                                 	 <div class="row form-group m-t-20 ">
                                    @if(Auth::user()->roll_no == $member->roll_no )
                                         <div class="col-md-3 offset-md-3" >
                                           
                                            
                                             <input type="hidden" style="width: 85%" name="member_rollno[]"  class="form-control float-right" value="{{explode(strtoupper(session('tenant')), $member->roll_no)[1]}}" required maxlength="15" placeholder="roll no">

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
                                    	<div class="col-md-3 offset-md-3">
		                                       
		                                        <input type="checkbox" class="float-left" style="width: 15%" checked >
                                            

		                                         <input type="text" style="width: 85%" name="member_rollno[]"  class="form-control float-right" value="{{explode(strtoupper(session('tenant')), $member->roll_no)[1]}}" required maxlength="15" placeholder="roll no">

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

                                @for($i=$project->project_members()->withTrashed()->count(); $i<5; $i++)
                                  <div class="row form-group m-t-20 ">
                                	<div class="col-md-3 offset-md-3">
		                                        
                                        <input type="checkbox" class="float-left" style="width: 15%" >
                                        
                                         <input type="text" style="width: 85%" name="member_rollno[]"  class="form-control float-right" value="{{ old('member_rollno[]')}}" required maxlength="15" placeholder="roll no">

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

                                

                                
                                      
                                
                        </form>    
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-3 mb-3">
                <div class="card  card_shadow w-100 borderless" id="user_widget">
                    <div class="card-header  " style="background-color: #F39C12">
                      <div id="card_img">
                        <img class="card-img img-circle bg-primary" src="/images/test-image.jpg" alt="Card image cap">
                      </div>
                      <div class="card_user_detail">
                         <span style="font-size: 1.2em">{{Auth::user()->name}}</span><br>
                           <span >{{Auth::user()->roles->first()->name}}</span><br>
                           <span >{{Auth::user()->roll_no}}</span><br>
                      </div>
                   
               </div>             
                <div class="card-body ">
                 
                  <ul class="nav flex-column text-center text-muted">
                      <li class="nav-item">
                        <span class="badge badge-light">{{Auth::user()->projects->count()}}</span><br>
                        <a class="nav-link" href="{{route('user.projects.index')}}">Projects </a>
                      </li>
                      <li class="nav-item">
                         <span class=" badge badge-light">{{Auth::user()->event1s()->count()}}</span><br>
                        <a class="nav-link" href="{{route('user.events.index')}}">Events</a>
                      </li>
                      <li class="nav-item">
                        <span class=" badge badge-light">{{Auth::user()->downloads->count()}}</span><br>
                        <a class="nav-link" href="{{route('user.downloads.index')}}">Downloads </a>
                      </li>                     
                      <li class="nav-item">
                        <span class="badge ">{{Auth::user()->posts->count()}}</span><br>
                        <a class="nav-link active" href="{{route('user.posts.index')}}"><h7>posts<h7> </a>
                      </li>
                    </ul> 
                    
                      
                </div>
                
                <div class="card-footer bg-white borderless">
                  <div class="row">
                    <div class="col-md-6">
                      <button class="btn btn-primary btn-sm btn-block" onclick="document.getElementById('projectEditForm').submit();">save </button>
                    </div>
                    <div class="col-md-6">
                      <button class="btn btn-outline-primary btn-sm btn-block">reset</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card w-100 mt-3 borderless" >
                <div class="card-body">                       
              
                  <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">upload new project</a>
                  <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">upload new note</a>
                  <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">create new event</a>
                   <a href="{{route('user.projects.create')}}" class=" btn btn-outline-primary btn-block ">create new post</a>
                </div>
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