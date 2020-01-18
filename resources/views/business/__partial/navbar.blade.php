
@if(Auth::check())
@if(Auth::guard('busines')->check() || Auth::guard('personal'))
@endif
@else
<ul class="nav navbar-menu">
        <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
        <li class="nav-item"><a href="{{ url('/') }}" class="nav-link"><i data-feather="box"></i> Beranda</a></li>
        <li class="nav-item"><a href="{{ url('business/dashboard') }}" class="nav-link"><i data-feather="box"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('business.clas.index')}}" class="nav-link"><i data-feather="box"></i> Classes</a></li>
        <li class="nav-item with-sub">
            <a href="" class="nav-link"><i data-feather="pie-chart"></i> Personal Accounts</a>
            <ul class="navbar-menu-sub">
                <li class="nav-sub-item"><a href="{{ route('busines.invite') }}" class="nav-sub-link badge badge-info text-white tx-bold">Invite</a></li>
                <li class="nav-sub-item"><a href="{{ route('business.clas_personal.index',['type' => 'teacher?approve=1']) }}" class="nav-sub-link">Teacher</a></li>
                <li class="nav-sub-item"><a href="{{ route('business.clas_personal.index',['type' => 'student?approve=1']) }}" class="nav-sub-link"></i>Student</a></li>
            </ul>
        </li>
        <li class="nav-item"><a href="{{ route('business.lesson_business.index')}}" class="nav-link"><i data-feather="box"></i> Lesson</a></li>
        </ul>
        
@endif