<ul class="nav navbar-menu">
<li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
<li class="nav-item"><a href="{{ url('/') }}" class="nav-link"><i data-feather="box"></i> Beranda</a></li>
<li class="nav-item with-sub">
    <a href="#" class="nav-link"><i data-feather="pie-chart"></i> Sekolah</a>
    <div class="navbar-menu-sub soek">
    <div class="d-lg-flex ">
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
