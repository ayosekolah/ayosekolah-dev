
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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Poppins:400,500,600,700' rel="stylesheet">
    <style>
        *, html,body {
        font-family: 'Poppins', sans-serif !important;
        }	

    </style>
    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.css') !!}">
    @include('_partial.gtag')
  </head>
  <body class="page-profile">

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
