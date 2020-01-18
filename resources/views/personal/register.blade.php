
<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" type="image/x-icon" href="{!! asset('v1/images/defaults/17x17/Ayosekolah-logo-color-opaque.png') !!}">

    <title>Register for Personal | Ayo Sekolah</title>

    <!-- vendor css -->
    <link href="{!! asset('v1/lib/@fortawesome/fontawesome-free/css/all.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/ionicons/css/ionicons.min.css" rel="stylesheet') !!}">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.css') !!}">
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.auth.css') !!}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Poppins:400,500,600,700' rel="stylesheet">
    <style>
        body {
        font-family: 'Poppins', sans-serif;
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
        .content-auth {
          min-height: calc(100vh - 60px);
        }
    </style>
  </head>
  <body>

    <header class="navbar navbar-header navbar-header-fixed">
      <a href="#" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
      <div class="navbar-brand">
          <a href="{{ url('/') }}" class="df-logo d-lg-inline-block d-none">
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
        <ul class="nav navbar-menu">
            <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
            <li class="nav-item"><a href="{{ url('/') }}" class="nav-link"><i data-feather="box"></i> Beranda</a></li>
            <li class="nav-item with-sub">
            <a href="#" class="nav-link"><i data-feather="pie-chart"></i> Sekolah</a>
            <div class="navbar-menu-sub soek">
            <div class="d-lg-flex">
                <ul>
                <li class="nav-sub-item"><a href="{{ route('business.login')}}" class="nav-sub-link"></i>Login</a></li>
                </ul>
                <ul>
                    <li class="nav-sub-item"><a href="{{ route('business.register')}}" class="nav-sub-link"></i>Register</a></li>
                    </ul>
                </div>
            </div>
        </li>
        </ul>
            
      </div><!-- navbar-menu-wrapper -->
      <div class="navbar-right">
          <a href="{{ url('it')}}" style="color:#001737">Cari Soal</a>
          <a href="{{ route('personal.register')}}" class="ml-2 btn btn-success btn-sm">Daftar Yuk! Gratis</a>
          <a href="{{ route('personal.login')}}" class="pl-2" style="color:#001737">Login</a>
    </div><!-- navbar-right -->
    </header><!-- navbar -->
    <div class="content content-fixed content-auth bg-purple">
      <div class="container">
        <div class="media align-items-stretch justify-content-center ht-100p">

          <div class="media-body pd-y-30 pd-lg-x-50 pd-xl-x-60 align-items-center d-none d-lg-flex pos-relative">
            <div class="mx-lg-wd-500 mx-xl-wd-550">
              <img src="{{ url('v1/images/defaults/personal-auth.png')}}" class="img-fluid" alt="">
            </div>
            <div class="pos-absolute b-0 r-0 tx-12">
              {{-- Social media marketing vector is created by <a href="https://www.freepik.com/pikisuperstar" target="_blank">pikisuperstar (freepik.com)</a> --}}
            </div>
          </div><!-- media-body -->
          <div class="sign-wrapper mg-lg-r-50 mg-xl-r-60">
                <div class="pd-t-20 wd-100p">
                  <h4 class="tx-white mg-b-5">Buat Akun Baru!</h4>
              <p class="tx-white tx-16 mg-b-40">Gratis Daftar dengan Sangat Mudah.</p>
                  <form action="{{ route('personal.register.proccess') }}" method="POST" data-parsley-validate>
                    @csrf
                    <div class="form-group">
                        <label class="tx-white">Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"  value="{{ old('name') }}" placeholder="Enter your Name" name="name" required>
                        @if ($errors->has('name'))
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $errors->first('name') }}.</li>
                            </ul>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="tx-white">Email address</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter your email address" name="email"  value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $errors->first('email') }}.</li>
                            </ul>
                    @endif
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between mg-b-5">
                        <label class="mg-b-0-f tx-white">Password</label>
                        </div>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter your password" name="password" required>
                        @if ($errors->has('password'))
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $errors->first('password') }}.</li>
                            </ul>
                        @endif
                    </div>
                    <div class="tx-white form-group">
                      <div class="d-flex justify-content-between mg-b-5">
                      <label class="mg-b-0-f">Ulangi Password</label>
                      </div>
                      <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="Enter your password Again" name="password_confirmation" required>
                      @if ($errors->has('password_confirmation'))
                          <ul class="parsley-errors-list filled" id="parsley-id-5">
                              <li class="parsley-required">{{ $errors->first('password_confirmation') }}.</li>
                          </ul>
                      @endif
                    </div>
                    <div class="form-group tx-12 tx-white" >
                        By clicking <strong>Create an account</strong> below, you agree to our terms of service and privacy statement.
                    </div>
                    <button class="btn btn-brand-02 btn-block tx-white">Create Account</button>
                </form>
                  <div class="divider-text">or</div>
                  <div class="tx-13 mg-t-20 tx-center text-white">Already have an account? <a class="tx-white" href="{{ route('personal.login') }}"><b>Sign In</b></a></div>
                </div>
              </div><!-- sign-wrapper -->
        </div><!-- media -->
      </div><!-- container -->
    </div><!-- content -->
    <script src="{!! asset('v1/lib/jquery/jquery.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/feather-icons/feather.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/perfect-scrollbar/perfect-scrollbar.min.js') !!}"></script>

    <script src="{!! asset('v1/assets/js/dashforge.js') !!}"></script>

    <!-- append theme customizer -->
    <script src="{!! asset('v1/lib/js-cookie/js.cookie.js') !!}"></script>
    <script src="{!! asset('v1/assets/js/dashforge.settings.js') !!}"></script>

    <script src="{!! asset('v1/lib/prismjs/prism.js') !!}"></script>
    <script src="{!! asset('v1/lib/parsleyjs/parsley.min.js') !!}"></script>
  </body>
</html>
