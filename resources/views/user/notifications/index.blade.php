
@extends('layouts.app')

@section('content')

<div class="main-container">

    <!-- heading -->
	<div class="container-fluid w-100" id="top_header" >
   <h2 class="text-center">All Notifications</h2>
	</div>	

    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="list-group mt-3 mb-3">
      	@foreach($notifications as $notification)
          
            <a href="{{$notification->data['url']}}" class="list-group-item list-group-item-action flex-column align-items-start" style="{{$notification->read_at ? '' : 'background-color: #EDF2FA;'}}">
              <div class="w-100 ">
                <p class="mb-1">{{$notification->data['message']}}</p>
                @switch($notification->type)
                    @case('App\Notifications\DownloadNotification') 
                        <i class="fas fa-download"></i>
                        @break
                    @case('App\Notifications\Event1MemberNotification')     
                    @case('App\Notifications\Event1Notification') 
                        <i class="fas fa-calendar-alt " ></i>
                        @break
                    @case('App\Notifications\PostNotification') 
                        <i class="fab fa-forumbee" ></i>
                        @break
                    @case('App\Notifications\ProjectNotification') 
                        <i class="fas fa-project-diagram " ></i>
                        @break        
                    @default
                        <i class="fas fa-comment " ></i>
                @endswitch
                <small class=" text-muted">{{$notification->created_at->diffForHumans(Carbon\Carbon::now())}}</small>
              </div>
            </a>
           
        @endforeach 
        </div> 

        <div class="row">
          <div class="col-auto offset-md-4">
            {{$notifications->links( "pagination::bootstrap-4") }}
          </div>
        </div>
 
  
      </div>
    </div>

    
    
</div>


@endsection