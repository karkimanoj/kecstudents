{{--
<nav class="navbar navbar-default mbottom-0 ">
  <div class="container-fluid">
    Brand and toggle get grouped for better mobile display     <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#colapsable_navbar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand " style="display: flex;" href="{{ route('home') }}"><i class="fas fa-graduation-cap fa-5x "  data-fa-transform="shrink-8 up-6" style="color:#228AE6"></i> <span style="font-size: 2.3rem; margin-left: 4px" id="brand_name"> Kecstudents</span></a>
    </div>

     Collect the nav links, forms, and other content for toggling 
    <div class="collapse navbar-collapse" id="colapsable_navbar">
      <ul class="nav navbar-nav" id="navbar_items">
        <li ><a href="#">Learn </a></li>
        <li><a href="#">Discuss</a></li>
         <li><a href="#">Share</a></li>
        
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::guest())
          <li><a href="{{ route('login') }}">login</a></li>
          <li><a href="{{ route('register') }}">Join the community</a></li>
        @else
        <li class="dropdown ">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span>hy {{Auth::user()->name}} <span> 
          </a>
          <ul class="dropdown-menu">
            <li><a href="#">profile</a></li>
            <li><a href="#">Notification</a></li>
            <li><a href="{{ route('manage.dashboard') }}">Manage</a></li>
            <li role="separator" class="divider"></li>
            <li><form method="POST" action="{{ route('logout') }}" id="logoutForm">
                {{csrf_field()}}
                <a href='#' class="m-l-20" onclick="document.getElementById('logoutForm').submit();" name="logout" >logout</a>
                </form>
            </li>
          </ul>
        </li>
        @endif
      </ul>

    </div>.navbar-collapse 
  </div>container-fluid 
</nav>
--}}



<nav class="navbar navbar-expand-lg navbar-light " id="main_navbar">
  <a class="navbar-brand "  href="{{ route('home') }}">
   <!-- <img src="{{--asset('images/Kecstudentslogo2.jpg')--}}" height="50" width="140"> -->
    <img src="{{count(App\Tenant::where('identifier', session('tenant'))->get() ) ? 
   asset(App\Tenant::where('identifier', session('tenant'))->first()->logo) : ''}}" height="70" width="160" class="img-fluid" alt="logo">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav"  id="navbar_items">
       <li class="nav-item ">
          <a class="nav-link" href="{{route('downloads.home', 9)}}">Download </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('projects.home', ['category'=>'subject', 'cat_id'=>0])}}">Project</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('user.events.index')}}">Event</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('posts.home')}}">Discuss</a>
        </li>
    </ul>

    <ul class="navbar-nav  nav-pill ml-auto " id="notify_dropdown">
        <li class="nav-item dropdown">
          <a class="nav-link text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-2x" style="color: grey"></i> 
           
              <span class="badge badge-danger">{{Auth::user()->unreadNotifications->count()}}</span>
            
          </a>
            <ul class="dropdown-menu">
              <li class="head text-light bg-dark">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-12">
                    <span>Notifications (3)</span>
                    <a href="{{route('notification.markAll')}}" class="float-right text-light">Mark all as read</a>
                  </div>
              </li>

              <!--notifications start $notification->data['url'] -->
             <li >
                <ul class="list-group  ul_notification_container">
                  @foreach(Auth::user()->notifications as $notification)
                    @if($loop->index >= 30)
                      @break
                    @endif
            
                    <a href="{{route('notification.markOne', $notification->id)}}" class="notification-box list-group-item list-group-item-action  pl-0 pr-0" style="{{$notification->read_at ? '' : 'background-color: #EDF2FA;'}}">
                      <div class="row">   
                        <div class="col-lg col-sm col ">
                          <div class="container ">
                            {!!$notification->data['message'] !!}
                          </div>
                          <div class="container">
                          <!-- icon according to notification type -->
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
              
                            <small class=" text-secondary">{{$notification->created_at->diffForHumans(Carbon\Carbon::now())}}</small>
                            
                          </div>
                        </div>    
                      </div>

                    </a>


                  @endforeach
                </ul>
              </li> 
              <!--notification end-->

              <li class="footer bg-dark text-center">
                <a href="{{route('notifications.index')}}" class="text-light">View All</a>
              </li>
            </ul>
        </li>
    </ul>    

    <ul class="navbar-nav ml-auto">
        @if(Auth::guest())
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        
         @elseif(Auth::check())
          <li class="nav-item dropdown pull-right">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"  >
              <span> {{Auth::user()->name}} <span> 
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="{{route('notifications.index')}}">Notification </a>
               @if(Auth::user()->hasRole(['superadministrator', 'administrator']) )
              <a class="dropdown-item" href="{{ route('users.index') }}">Manage</a>
              @endif
              <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display: none">
                {{csrf_field()}} </form>
                <a class="dropdown-item" href='#' onclick="document.getElementById('logoutForm').submit();" name="logout" >logout</a>               
            </div>

          </li>
        @endif
    </ul> 
    
  </div>
</nav>

