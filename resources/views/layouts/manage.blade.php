<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Devmarketer</title>

    <!-- Styles -->

        <!--      not needed because we installed bootstrap via npm -->
     
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">

        @yield('styles')
               

</head>
<body> @include('_includes.nav.main') 
    <div id="app">
      <!-- navbar -->
          
        <div class="wrapper">
           <!--sidebar -->            
              @include('_includes.nav.manageSidebar')

              <div id="content">
                <div class="row">
                  <div class="col-md-12">
                  <!-- click button to collapse sidebar-->
                      <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                          <i class="fa fa-arrow-right" aria-hidden="true"></i>
                      </button>
                      <!--  display success and error messages -->
                      @include('_includes.messages')
                       

                    @yield('content')

                  </div>
                </div>
               

              </div>
        </div>
    </div>
 

    <script src="{{ asset('js/app.js') }}"> </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>


    @yield('scripts')

    <script type="text/javascript">
        $(document).ready(function () {

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $.each($('.col_ul').children('li'), function() {
           // $.each($('#pageSubmenu').next().children('li'), function(){
             if($(this).hasClass('active'))
                //bootstrap collapse attribute
               $('.col_ul').collapse('show');
            });


        });
    </script>
    </body>
</html>
