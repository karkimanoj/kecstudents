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



<nav class="navbar navbar-expand-lg navbar-light ">
  <a class="navbar-brand "  href="{{ route('home') }}">
    {{--<i class="fas fa-graduation-cap fa-lg"  style="color:#228AE6"></i> --}}
    <img src="{{asset('images/Kecstudentslogo2.jpg')}}" height="50" width="140">
    {{--<span style="font-size: 1.5rem; margin-left: 4px; font-weight:100;" id="brand_name"> Kecstudents</span>--}}
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav"  id="navbar_items">
       <li class="nav-item ">
          <a class="nav-link" href="#">Learn </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Discuss</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Share</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        @if(Auth::guest())
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Join the community</a></li>
        @else

          <li class="nav-item dropdown pull-right">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"  >
              <span>hy {{Auth::user()->name}} <span> 
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">profile</a>
              <a class="dropdown-item" href="#">Notification </a>
              <a class="dropdown-item" href="{{ route('manage.dashboard') }}">Manage</a>

              <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display: none">
                {{csrf_field()}} </form>
                <a class="dropdown-item" href='#' onclick="document.getElementById('logoutForm').submit();" name="logout" >logout</a>               
            </div>

          </li>
        @endif
    </ul> 
    
  </div>
</nav>