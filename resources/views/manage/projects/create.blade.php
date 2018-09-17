

@extends('layouts.manage')

@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="main-container">
    

    <div class="row ">
        <div class="col-md-11 offset-md-1 ">
        	<h2><center>UPLOAD NEW PROJECT</center></h2>
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" action="{{route('projects.store')}} " enctype="multipart/form-data">
                                {{csrf_field()}}    
                                        
                                <div class="row form-group m-t-20{{ $errors->has('name')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">Name of the project:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <input type="text" name="name" minlength="4" class="form-control" value="{{old('name')}}" required maxlength="255">

                                        @if($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                     </div>                 
                                </div>

                                <div class=" row form-group m-t-20" id="subject_div">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">choose project category</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control" id="subject_select" name="subject" required>
                                            @foreach($subjects as $subject)
                                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group m-t-20{{ $errors->has('abstract')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">Abstract:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <textarea class="form-control" required rows="14" name="abstract" >{{old('abstract')}}</textarea>
                                       
                                        <span class="help-block">
                                            @if($errors->has('abstract'))
                                                <strong>{{ $errors->first('abstract') }}</strong>
                                                @else
                                                <small class="form-text text-muted"> hint: you can copy and paste abstract from your project documentation file</small>
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
                                                <input type="url" name="link" class="form-control" value="{{old('link')}}" aria-describedby="basic-addon2" maxlength="255" >
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
                                <div class=" row form-group m-t-20 {{ $errors->has('file')?'has-error':'' }}">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">file</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" name="file" placeholder="aaaaaaa" class="form-control" accept=".pdf,.docx" required value="{{old('file')}}">
                                        @if($errors->has('file'))
                                        <strong>{{ $errors->first('file') }}</strong>
                                        @else
                                        <small class="form-text text-muted">
                                         file format should be .pdf, .docx, or .zip
                                        </small>
                                        @endif
                                    </div>
                                </div>

                                <div class=" row form-group m-t-20 {{ $errors->has('images')?'has-error':'' }}">
                                    <div class="col-md-3" >               
                                       <label class="float-right m-r-20" >screenshots/photos
                                       </label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" name="images[]" multiple class="form-control" accept="image/*"   >
                                        @if($errors->has('images'))
                                          <strong>{{ $errors->first('images') }}</strong>
                                        @else
                                          <small class="form-text text-muted">
                                          optional. max 2. Image format must be either jpeg, png or gif
                                        </small>
                                        @endif
                                    </div>
                                </div>

                                    <div class="row m-t-20">
                                        <div class="col-md-3">
                                             <label class="m-t-20">project members ( max 6):</label> 
                                        </div>
                                         <div class="col-md-8">
                                             <label class=" m-t-20 m-l-20"><span class="form-text text-muted">Hint: tick checkbox to add members Rollno format: 044BCT2071</span> </label> 
                                        </div>
                                         
                                    </div>
                                           
                                <div class="row form-group  {{ $errors->has('member_rollno[0]')?'has-error':'' }}">
                                    @if(Auth::user()->hasRole('superadministrator') || Auth::user()->hasRole('administrator'))
                                         <div class="col-md-3 offset-md-3" >
                                          
                                            
                                             <input type="text" style="width: 85%" name="member_rollno[]"  class="form-control float-float-right" value="{{old('member_rollno[0]')}}"  required maxlength="10" placeholder="roll no">

                                            @if($errors->has('member_rollno[0]'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('member_rollno[]') }}</strong>
                                                </span>
                                            @endif
                                          </div> 
                                          <div class="col-md-5">
                                             <input type="text" name="member_name[]" minlength="4" class="form-control" value="{{old('member_name[0]')}}" required maxlength="255" placeholder="name">

                                            @if($errors->has('member_name[0]'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('member_name[]') }}</strong>
                                                </span>
                                            @endif
                                           </div> 
                                    @else
                                            <div class="col-md-3 offset-md-3" style="display: none;">
                                            
                                            
                                             <input type="hidden" style="width: 85%" name="member_rollno[0]"  class="form-control float-float-right" value="{{explode(strtoupper(session('tenant')), Auth::user()->roll_no)[1]}}" required maxlength="10" placeholder="roll no">

                                            @if($errors->has('member_rollno[0]'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('member_rollno[0]') }}</strong>
                                                </span>
                                            @endif
                                          </div> 
                                          <div class="col-md-5">
                                             <input type="hidden" name="member_name[0]" minlength="4" class="form-control" value="{{Auth::user()->name or old('member_name[0]')}}" required maxlength="255" placeholder="name">

                                            @if($errors->has('member_name[0]'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('member_name[0]') }}</strong>
                                                </span>
                                            @endif
                                           </div> 
                                    @endif                    
                                </div>




                               @for($i=0; $i<4 ;$i++) 
                                <div class="row form-group m-t-20 {{ $errors->has('member_rollno[$i]')?'has-error':'' }}">
                                       
                                     <div class="col-md-3 offset-md-3">
                                        
                                        <input type="checkbox" class="float-left" style="width: 15%" >
                                        
                                         <input type="text" style="width: 85%" name="member_rollno[$i]"  class="form-control float-float-right" value="{{old('member_rollno[$i]')}}" required maxlength="10" placeholder="roll no">

                                        @if($errors->has('member_rollno[$i]'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('member_rollno[$i]') }}</strong>
                                            </span>
                                        @endif
                                     </div> 
                                     <div class="col-md-5">
                                         <input type="text" name="member_name[$i]" minlength="4" class="form-control" value="{{old('member_name[$i]')}}" required maxlength="255" placeholder="name">

                                        @if($errors->has('member_name[$i]'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('member_name[$i]') }}</strong>
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
<script type="text/javascript"> 
$(document).ready(function(){
alert('ssssss');
});
</script>

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