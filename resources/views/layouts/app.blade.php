<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  

    <title>Students Portal for Engineering Colleges</title>

    <!-- Styles -->

        <!--      not needed because we installed bootstrap via npm from bash -->
     
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
      @yield('styles')
  

</head>
<body>
    <div id="app">

      @include('_includes.nav.main')

      @include('_includes.messages')
      
        @yield('content')

        @include('_includes.footer')
    </div>

  

    
    @yield('scripts')
    <script type="text/javascript">
      $(document).ready(function (){
       
        count = {{Auth::user()->unreadNotifications->count()}};
        if(count)
          $('#notify_dropdown .badge').show();
        else
          $('#notify_dropdown .badge').hide();
         
        userId = {{Auth::user()->id}};

        Echo.private('App.User.' + userId)
        .notification((notification) => {
          
          str = notification.type;
          notification_type = str.split("\\")[2];  
          switch(notification_type) {
              case 'DownloadNotification':
                 notification_icon = '<i class="fas fa-download"></i>';
                  break;
              case 'Event1Notification':
              case 'Event1MemberNotification':
                  notification_icon = '<i class="fas fa-calendar-alt " ></i>';
                  break;
              case 'PostNotification':
                  notification_icon = '<i class="fab fa-forumbee" ></i>';
                  break;
              case 'ProjectNotification':
                  notification_icon = '<i class="fas fa-project-diagram " ></i>';
                  break;        
              default:
                  notification_icon = '<i class="fas fa-comment"></i>';
              }
              
            ind_notification = ['<li class="notification-box" >',
                          ' <a href="'+notification.url+'">',
                        '<div class="row"> <div class="col-lg col-sm col "> <div class="container ml-2">',
                        notification.message,
                        '</div><div class="container ml-2">',
                        notification_icon,
                        '<small class=" text-secondary"> just now </small>',
                        ' </div> </div> </div></a></li>'
                        ].join('');

          $('.ul_notification_container').prepend(ind_notification);
          

          $('#notify_dropdown .badge').show();
          if($('#notify_dropdown .badge').length)
          {
            $badge = $('#notify_dropdown .badge');
            count=parseInt($badge.text());
          
            count = count + 1;
            $badge.text(count);
          } 
    });
  });
    </script>
</body>
</html>
