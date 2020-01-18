
<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{!! asset('v1/images/defaults/17x17/Ayosekolah-logo-color-opaque.png') !!}">
    
    @yield("header")
    <!-- vendor css -->
    <link href="{!! asset('v1/lib/@fortawesome/fontawesome-free/css/all.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/ionicons/css/ionicons.min.css" rel="stylesheet') !!}">
    <link href="{!! asset('v1/lib/typicons.font/typicons.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/prismjs/themes/prism-vs.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/jqvmap/jqvmap.min.css') !!}" rel="stylesheet">


    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.css') !!}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Poppins:400,500,600,700' rel="stylesheet">
    <style>
        body {
        font-family: 'Poppins', sans-serif;
        background: #F2F2F2;
        }	
        .navbar-menu-wrapper {
          justify-content : left;
        }
        @media (min-width: 1200px){
        .navbar-header .navbar-right {
            width: 315px;
            padding-left: 10px;
        }
        .navbar-header .navbar-brand {
          width: 160px;
          padding: 0 0 0 20px;
          margin-top: -3px;
        }
        }
    </style>
  </head>
  <body class="page-profile">
    <header class="navbar navbar-header navbar-header-fixed">
      <a href="#" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
      <div class="navbar-brand">
        <a href="{{ url('/') }}" class="df-logo">
          <img src="{{ url('v1/images/defaults/logo-v1/Ayosekolah-logo-100px-transparent.png')}}" width="130px">
        </a>
      </div><!-- navbar-brand -->
      <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
          <a href="{{ url('/') }}" class="df-logo">
            <img src="{{ url('v1/images/defaults/logo-v1/Ayosekolah-logo-100px-transparent.png')}}" width="100px">
          </a>
          <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
        </div><!-- navbar-menu-header -->
        @include('business.__partial.navbar')
      </div><!-- navbar-menu-wrapper -->
      <div class="navbar-right">
        <div class="dropdown dropdown-profile">
          <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
            <div class="avatar avatar-sm"><img src="{{ getImg(Auth::guard('busines')->user()->image)}}" class="rounded-circle" alt=""></div>
          </a><!-- dropdown-link -->
          <div class="dropdown-menu dropdown-menu-right tx-13">
            <div class="avatar avatar-lg mg-b-15"><img src="{{ getImg(Auth::guard('busines')->user()->image)}}" class="rounded-circle" alt=""></div>
            <h6 class="tx-semibold mg-b-5">{{ Auth::guard('busines')->user()->name }}</h6>
            <p class="mg-b-25 tx-12 tx-color-03">Busines</p>

            <a href="{{ route('business.edit') }}" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('business.logout') }}" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </div><!-- navbar-right -->
    </header><!-- navbar -->

    <div class="content content-fixed">
        <div class="container">
            @yield('contents')
        </div>
    </div><!-- content -->

    <script src="{!! asset('v1/lib/jquery/jquery.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/feather-icons/feather.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/perfect-scrollbar/perfect-scrollbar.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/prismjs/prism.js') !!}"></script>

    <script src="{!! asset('v1/assets/js/dashforge.js') !!}"></script>

    @yield("footer")
  </body>
</html>
