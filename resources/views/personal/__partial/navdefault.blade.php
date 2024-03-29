<ul class="nav navbar-menu">
<li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
<li class="nav-item"><a href="{{ url('/') }}" class="nav-link"><i data-feather="box"></i> Beranda</a></li>
<li class="nav-item"><a href="{{ url('personal/dashboard') }}" class="nav-link"><i data-feather="box"></i> Dashboard</a></li>
<li class="nav-item"><a href="{{ route('personal.join')}}" class="nav-link"><i data-feather="box"></i> Join</a></li>
<li class="nav-item"><a href="{{ url('it')}}" class="nav-link"><i data-feather="box"></i> Find a Quiz</a></li>
<li class="nav-item with-sub">
    <a href="#" class="nav-link"><i data-feather="pie-chart"></i>My Quizzes</a>
    <ul class="navbar-menu-sub">
        <li class="nav-sub-item"><a href="{{ url('personal/teacher/quiz/class/all') }}" class="nav-sub-link">By Class</a></li>
        <li class="nav-sub-item"><a href="{{ url('personal/my_quiz/general/all') }}" class="nav-sub-link"></i>General</a></li>
    </ul>
</li>
<li class="nav-item with-sub">
    <a href="" class="nav-link"><i data-feather="pie-chart"></i> Create a New Quiz</a>
    <ul class="navbar-menu-sub">
        <li class="nav-sub-item"><a href="{{ url('personal/teacher/quiz/class/create') }}" class="nav-sub-link">By Class</a></li>
        <li class="nav-sub-item"><a href="{{ route('personal.my_quiz.general.create')}}" class="nav-sub-link"></i>General</a></li>
    </ul>
</li>
<li class="nav-item with-sub">
    <a href="" class="nav-link"><i data-feather="pie-chart"></i>Quizzes </a>
    <ul class="navbar-menu-sub">
        <li class="nav-sub-item"><a href="{{ route('personal.student.class')}}" class="nav-sub-link">Your Quiz</a></li>
        <li class="nav-sub-item"><a href="{{ route('student.clas.score')}}" class="nav-sub-link"></i>Your Score</a></li>
    </ul>
</li>
<li class="nav-item with-sub">
    <a href="" class="nav-link"><i data-feather="pie-chart"></i> Report</a>
    <ul class="navbar-menu-sub">
        <li class="nav-sub-item"><a href="{{ route('personal.quiz.clas.report') }}" class="nav-sub-link">By Class</a></li>
        <li class="nav-sub-item"><a href="{{ url('quiz/general/report')}}" class="nav-sub-link"></i>General</a></li>
    </ul>
</li>
<li class="nav-item"><a href="{{ route('personal.curriculum.index') }}" class="nav-link"><i data-feather="box"></i> Curriculum</a></li>
</ul>