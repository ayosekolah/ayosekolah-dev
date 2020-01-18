
<ul class="nav navbar-menu">
    <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link"><i data-feather="box"></i> Beranda</a></li>
    <li class="nav-item"><a href="{{ url('personal/dashboard') }}" class="nav-link"><i data-feather="box"></i> Dashboard</a></li>
    <li class="nav-item"><a href="{{ route('personal.student.class')}}" class="nav-link"><i data-feather="box"></i> Quizzes</a></li>
    <li class="nav-item"><a href="{{ route('personal.join')}}" class="nav-link"><i data-feather="box"></i> Join</a></li>
    <li class="nav-item"><a href="{{ url('personal/my_quiz/general/all') }}" class="nav-link"><i data-feather="box"></i> My Quiz</a></li>
    <li class="nav-item"><a href="{{ url('personal/student/quiz/class/activity_score')}}" class="nav-link"><i data-feather="box"></i> Score</a></li>
    <li class="nav-item"><a href="{{ url('quiz/general/report')}}" class="nav-link"><i data-feather="box"></i> Report</a></li>
    <li class="nav-item"><a href="{{ url('it')}}" class="nav-link"><i data-feather="box"></i> Find a Quiz</a></li>
    <li class="nav-item"><a href="{{ route('personal.my_quiz.general.create')}}" class="nav-link btn btn-secondary text-white p-1"><i data-feather="box"></i> Create new a Quiz</a></li>
</ul>