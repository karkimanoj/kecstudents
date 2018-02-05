@extends('layouts.manage')

@section('content')
<div class="main-container">
    <div class="row ">
        <div class="col-md-10 col-md-offset-1 ">
        	<h2><center>Edit upload</center></h2>
              <div class="panel panel-default m-t-25">
                    <div class="panel-body">
                        <form method="POST" action="{{route('downloads.update', $download->id)}} ">
                                {{method_field('PUT')}}
                                {{csrf_field()}}    
                                        
                                <div class=" row form-group m-t-10">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">Category</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{$download->download_category->name}}
                                    </div>
                                </div>

                                <div class=" row form-group  m-t-20">
                                    <div class="col-md-3">               
                                       <label class="right m-r-20">faculty/semester</label>
                                    </div>
                                    
                                        @if(trim($download->download_category->category_type)=='subject')
                                            <div class="col-md-4">
                                                {{$download->download_detail1->subject->name}}
                                            </div>
                                        @else
                                            <div class="col-md-4">
                                                {{$download->download_detail2->faculty->name}} semester-{{$download->download_detail2->semester}}
                                            </div>
                                        @endif
                                    
                                    
                                </div>


                                <div class="row form-group m-t-20{{ $errors->has('description')?'has-error':'' }} ">
                                    <div class="col-md-3">    
                                        <label class="right m-r-20">description:</label>
                                    </div>    
                                     <div class="col-md-8">
                                         <textarea class="form-control" required rows="10" name="description" >
                                             {{$download->description}}
                                         </textarea>
                                        @if($errors->has('description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                     </div>                 
                                </div>

                                <div class=" row form-group m-t-20">
                                    <div class="col-md-3 m-r-20">               
                                       <label class="right m-r-20">filepath</label>
                                    </div>
                                    <div class="col-md-8">
                                        {{$download->filepath}}
                                    </div>
                                </div>

                                
                                        <center><input type="submit" name="update" value="update" class="btn btn-primary"></center>
                                
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

