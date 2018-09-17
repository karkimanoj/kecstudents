@extends('layouts.manage')
      

      
@section('content')
  
<div class="main-container">

    <div class="row">
      <div class="col-md-6">
        <h1>All Notices</h1>  
      </div>

      <div class="col-md-4 offset-md-2 ">
        <a href="{{route('notices.create')}}" class="btn  btn-primary float-right"> Create New Notice</a>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h4><span class="text-muted"></span> </h4>
        
        
        <table class="table m-t-20">
          <thead>
            <th>#</th>
            <th>Title</th>
            <th>Uploaded By</th>
            <th>Date Created</th>
            <th>Actions</th>
          </thead>
          <tbody>
            @foreach($notices as $notice)
              <tr>
                <td>{{$notice->id}}</td>
                <td>{{ substr(strip_tags($notice->title ),0,60) }} <span style="color: blue"> {{ strlen(strip_tags($notice->title ))>60?'....':'' }} </span>
                 </td>  
                <td>{{$notice->user->name}}</td>
                <td>{{$notice->created_at->toDateTimeString()}}</td>
                <td >
                  <div class="input-group-btn">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                          <li><a href="{{route('notices.show', $notice->id)}}" > View </a>
                          </li>
                          <li><a href="{{route('notices.edit', $notice->id)}}"> Edit </a>
                          </li>
                         
                        </ul>
                    </div><!-- /btn-group -->

                  <!-- delete with modal-->
                  
                </td>
              </tr>   
            @endforeach                   
          </tbody>
        </table>
        <center>
        
        <div class="row">
              <div class="col-auto offset-md-4">
                {{$notices->links( "pagination::bootstrap-4") }}
              </div>
            </div>
        </center>
        </div>
      </div>


</div>
   
@endsection