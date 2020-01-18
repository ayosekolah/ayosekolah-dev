
@if(Auth::guard('busines')->check() || Auth::guard('personal')->check())
<div class="navbar-right">
<div class="dropdown dropdown-profile">
    <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
    <div class="avatar avatar-sm">
            @if(Auth::guard('personal')->check())
            <img src="{{ getImg(Auth::guard('personal')->user()->image)}}" class="rounded-circle" alt="">
            @else
            <img src="{{ getImg(Auth::guard('busines')->user()->image)}}" class="rounded-circle" alt="">
            @endif
        </div>
    </a><!-- dropdown-link -->
    <div class="dropdown-menu dropdown-menu-right tx-13">
    <div class="avatar avatar-lg mg-b-15">
            @if(Auth::guard('personal')->check())
                <img src="{{ getImg(Auth::guard('personal')->user()->image)}}" class="rounded-circle" alt="">
            @else
                <img src="{{ getImg(Auth::guard('busines')->user()->image)}}" class="rounded-circle" alt="">
            @endif
    </div>
    <h6 class="tx-semibold mg-b-5">
            @if(Auth::guard('personal')->check())
            {{ ucfirst(Auth::guard('personal')->user()->name)}}
        @else
            {{ ucfirst(Auth::guard('busines')->user()->name)}}
        @endif
    </h6>
    @if(Auth::guard('personal')->check())
        <a href="{{ route('personal.edit') }}" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
    @else
        <a href="{{ route('business.edit') }}" class="dropdown-item"><i data-feather="edit-3"></i> Edit Profile</a>
    @endif
   
    {{-- <a href="page-profile-view.html" class="dropdown-item"><i data-feather="user"></i> View Profile</a> --}}
    <div class="dropdown-divider"></div>
    {{-- <a href="page-help-center.html" class="dropdown-item"><i data-feather="help-circle"></i> Help Center</a>
    <a href="" class="dropdown-item"><i data-feather="life-buoy"></i> Forum</a>
    <a href="" class="dropdown-item"><i data-feather="settings"></i>Account Settings</a>
    <a href="" class="dropdown-item"><i data-feather="settings"></i>Privacy Settings</a> --}}
 
    @if(Auth::guard('personal')->check())
        <a href="{{ route('personal.logout') }}" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>
    @else
        <a href="{{ route('business.logout') }}" class="dropdown-item"><i data-feather="log-out"></i>Sign Out</a>
    @endif
    </div><!-- dropdown-menu -->
</div><!-- dropdown -->
</div><!-- navbar-right -->
@else
<div class="navbar-right">
    <a href="{{ url('it')}}" style="color:#001737">Cari Soal</a>
    <a href="{{ route('personal.register')}}" class="ml-2 btn btn-success btn-sm">Daftar Yuk! Gratis</a>
    <a href="{{ route('personal.login')}}" class="pl-2" style="color:#001737">Login</a>
</div>
@endif