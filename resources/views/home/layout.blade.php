
<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
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
        }	
        .navbar-menu {
          max-width: 100%;
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
        .soek {
          position: fixed;
          left: 0;
          width: 100%;
          padding-left: 270px;
          background: #2c135a;
          border: none;
          color: white;
          margin-top: 18px;
        }
        .navbar-menu-sub ul
        {
          color: white;
          min-width: 15px !important;
          border: none !important;
          margin-left: 0 !important;
        }

        .navbar-menu-sub ul li a {
          color: white !important;
        }
        }
    </style>
  </head>
  <body class="page-profile">
    <header class="navbar navbar-header navbar-header-fixed">
      <a href="#" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
      <div class="navbar-brand hidden-xs">
        <a href="{{ url('/') }}" class="df-logo d-lg-inline-block d-none">
          <img src="{{ url('v1/images/defaults/logo-v1/Ayosekolah-logo-100px-transparent.png')}}" width="130px">
        </a>
        {{-- <i class="fa fa-star d-inline-block d-lg-none"></i> --}}
      </div><!-- navbar-brand -->
      <div id="navbarMenu" class="navbar-menu-wrapper">
        <div class="navbar-menu-header">
          <a href="{{ url('/') }}" class="df-logo">
            <img src="{{ url('v1/images/defaults/logo-v1/Ayosekolah-logo-100px-transparent.png')}}" width="110px">
          </a>
          <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
        </div><!-- navbar-menu-header -->
            @if(Auth::guard('busines')->check())
                  @include('business.__partial.navbar')
            @elseif(Auth::guard('personal')->check())
            @if(Auth::guard('personal')->user()->type == 'teacher') 
            @include('personal.__partial.navteacher')
                @elseif(Auth::guard('personal')->user()->type == 'student') 
                    @include('personal.__partial.navstudent')
                @else
                    @include('personal.__partial.navdefault')
                @endif
            @else
            @include('home.__partial.navbar')
          @endif
      </div><!-- navbar-menu-wrapper -->
      @include('home.__partial.right_navbar')
      <div class="navbar-search">
        <div class="navbar-search-header">
          <input type="search" class="form-control" placeholder="Type and hit enter to search...">
          <button class="btn"><i data-feather="search"></i></button>
          <a id="navbarSearchClose" href="" class="link-03 mg-l-5 mg-lg-l-10"><i data-feather="x"></i></a>
        </div><!-- navbar-search-header -->
        <div class="navbar-search-body">
          <label class="tx-10 tx-medium tx-uppercase tx-spacing-1 tx-color-03 mg-b-10 d-flex align-items-center">Recent Searches</label>
          <ul class="list-unstyled">
            <li><a href="dashboard-one.html">modern dashboard</a></li>
            <li><a href="app-calendar.html">calendar app</a></li>
            <li><a href="../../collections/modal.html">modal examples</a></li>
            <li><a href="../../components/el-avatar.html">avatar</a></li>
          </ul>

          <hr class="mg-y-30 bd-0">

          <label class="tx-10 tx-medium tx-uppercase tx-spacing-1 tx-color-03 mg-b-10 d-flex align-items-center">Search Suggestions</label>

          <ul class="list-unstyled">
            <li><a href="dashboard-one.html">cryptocurrency</a></li>
            <li><a href="app-calendar.html">button groups</a></li>
            <li><a href="../../collections/modal.html">form elements</a></li>
            <li><a href="../../components/el-avatar.html">contact app</a></li>
          </ul>
        </div><!-- navbar-search-body -->
      </div><!-- navbar-search -->
      @include('_partial.gtag')
    </header><!-- navbar -->

    <div class="content content-fixed">
            @yield('contents')
    </div><!-- content -->

    {{-- <footer class="footer" style="">
      <div>
        <span>&copy; 2019 DashForge v1.0.0. </span>
        <span>Created by <a href="http://themepixels.me">ThemePixels</a></span>
      </div>
      <div>
        <nav class="nav">
          <a href="https://themeforest.net/licenses/standard" class="nav-link">Licenses</a>
          <a href="../../change-log.html" class="nav-link">Change Log</a>
          <a href="https://discordapp.com/invite/RYqkVuw" class="nav-link">Get Help</a>
        </nav>
      </div>
    </footer> --}}

    <script src="{!! asset('v1/lib/jquery/jquery.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/feather-icons/feather.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/perfect-scrollbar/perfect-scrollbar.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/prismjs/prism.js') !!}"></script>

    <script src="{!! asset('v1/assets/js/dashforge.js') !!}"></script>
    @yield("footer")
  </body>
</html>
