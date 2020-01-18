@extends('home.layout')
    @section('header')
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Poppins:400,500,600,700' rel="stylesheet">
    <link href="{{ asset('v1/lib/animate.css/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://kenwheeler.github.io/slick/slick/slick-theme.css">

    <title>Ayo Sekolah |  Platform digital untuk Berbagi pembelajaran </title>
            <style>
                .content, content-fixed {
                padding-top: 0em;
                padding: 0 !important;
                font-family: 'Poppins', sans-serif;
                }	
                .btn-circle {
                width: 45px;
                height: 45px;
                line-height: 45px;
                text-align: center;
                padding: 0;
                border-radius: 50%;
                }
                .bg-pings {
                    animation: animation_header 150000s infinite linear alternate;
                }
                .box_up {
                    margin-top: calc(-1.938rem - 1.95rem);
                }
                .box_up_1 .media-body{
                    padding: 10px;
                }
                .section_two {
                    animation: animation_wrapper 20000s infinite linear alternate;
                }
                .in_top{
                    margin-top: calc(-1.938rem - 0.1rem);
                }
                .wrap_section_two{
                    margin: 10px auto;
                }
                .section_four{
                    height: auto;
                }

                @keyframes animation_header {
                    0% {background-color: #46178F;}
                    50%{background-color: #46178F;}
                    25%{background-color:#E11B3C;}
                }

                @keyframes animation_wrapper {
                    0% {background-color: #1368CE;}
                    50%{background-color:#1368CE;}
                    100% {background-color: #26890C;}
                }

                @media only screen and (max-width: 600px) {
                .in_top{
                    margin-top: 10px;
                }
                .box_up_1{
                    padding-top: 1px;
                }
                .old_top{
                    margin-top:10px;
                }
            }
            </style>
    @endsection
    @section('contents')
        <div class="jumb bg-pings">
            <div class="jumbotron bg-pings text-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-8  pt-4 pb-5">
                            <img src="{{ url('v1/images/defaults/11826.jpg') }}" alt="" class="pb-3" width="70"> 
                        <h2 class="tx-30 pb-3 text-white"> AyoSekolah  </h2> 
                        <p class="tx-20 tx-light pb-2">Adalah platform digital untuk sharing pembelajaran bagi pelajar dan pengajar</p>
                        <a href="#section_two" class="btn btn-success">Get Started</a>  
                    </div>
                    <div class="col-md-4 text-center pt-4 pb-5">
                        <img clas="float-right" src="{{ url('v1/images/defaults/pngtube.com-education-clipart-png-1433814.png') }}" alt="" width="300px">
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="box_up">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 animated pulse">
                    <div class="box_up_1  shadow-sm bg-white rounded-5">
                        <div class="media">
                            <img src="{{ url('v1/images/defaults/3834.jpg') }}" class="wd-150  mg-r-20" alt="">
                                <div class="media-body">
                                <a href=""> <h5 class="mg-b-15 tx-inverse">Collaboration Sharing</h5></a>
                                Upload dan lihat materi pembelajaran
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 animated pulse">
                    <div class="box_up_1  shadow-sm bg-white rounded-5">
                        <div class="media">
                            <img src="{{ url('v1/images/defaults/14634.jpg') }}" class="wd-150  mg-r-20" alt="">
                            <div class="media-body">
                                <a href=""> <h5 class="mg-b-15 tx-inverse"> Upload Soal/Quiz</h5></a>
                                Upload Soal/Quiz untuk pengajar
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4 animated pulse">
                    <div class="box_up_1  shadow-sm bg-white rounded-5">
                        <div class="media">
                            <img src="{{ url('v1/images/defaults/adobe-stock-kid-laptop-headphones_feature.png') }}" class="wd-150  mg-r-20" alt="" height="100px">
                            <div class="media-body">
                                <a href=""> <h5 class="mg-b-15 tx-inverse">Latihan Soal</h5></a>
                                Kerjakan latihan soal untuk pelajar
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12 mb-3">
                <h3 class="text-white text-center p-5">Find Your Quiz</h3>
            </div> --}}
        <div class="section_two mt-5 pb-5">
            <div class="container">
            <div class="wrap_section_two "id="section_two">
                <div class="row">
                    <div class="col-md-12 mb-3 mt-4">
                            <h3 class="text-white text-left pt-4">New Quiz</h3>
                    </div>
                </div>
                <div class="row  {{ count($quiz) > 3 ? 's_c' : '' }}">
                        @foreach ($quiz as $index => $item)
                        <div class="col-md-3 mb-4"> 
                                <div class="card animated pulse">
                                <img src="{{ getImg($item->image) }}" class="card-img-top img-fluid img-responsive ht-150" alt="...">
                                    <div class="card-body ht-150">
                                        <h6 class="card-title">{{ $item->title }} </h6>
                                        <span class="text-info mb-5">{{ $item->quizQuestion->count() }}</span> Question <br>
                                        @if(Auth::guard("personal")->check())
                                            @if($item->teacherAll->id == Auth::guard('personal')->user()->id)
                                                <button class="btn bg-danger text-white mt-2" disabled>It's your Quiz</button> 
                                            @else
                                            <a href="{{ url('detail_quiz/'.$item->code) }}" class="btn bg-purple text-white mt-2">Go Quiz</a> 
                                            @endif
                                        @elseif(Auth::guard("busines")->check())
                                            
                                        @else
                                            <a href="{{ url('detail_quiz/'.$item->code) }}" class="btn bg-purple text-white mt-2">Go Quiz</a> 
                                        @endif
                                    </div>
                                </div>
                        </div>
                        @endforeach
                </div>    
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h3 class="text-white text-left pt-4">Populer Quiz</h3>
                    </div>
                </div>
                <div class="row {{ count($populerQuiz) > 3 ? 's_c' : '' }}">
                        @foreach ($populerQuiz as $index => $item)
                        <div class="col-md-3 mb-4"> 
                                <div class="card animated pulse">
                                <img src="{{ getImg($item->image) }}" class="card-img-top img-fluid img-responsive ht-150" alt="...">
                                    <div class="card-body ht-150">
                                        <h6 class="card-title">{{ $item->title }} </h6>
                                        <span class="text-info mb-5">{{ $item->quizQuestion->count() }}</span> Question <br>
                                        @if(Auth::guard("personal")->check())
                                            @if($item->teacherAll->id == Auth::guard('personal')->user()->id)
                                                <button class="btn bg-danger text-white mt-2" disabled>It's your Quiz</button> 
                                            @else
                                            <a href="{{ url('detail_quiz/'.$item->code) }}" class="btn bg-purple text-white mt-2">Go Quiz</a> 
                                            @endif
                                        @elseif(Auth::guard("busines")->check())
                                            
                                        @else
                                            <a href="{{ url('detail_quiz/'.$item->code) }}" class="btn bg-purple text-white mt-2">Go Quiz</a> 
                                        @endif
                                    </div>
                                </div>
                        </div>
                        @endforeach
                </div>    
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <h3 class="text-white text-left pt-4">Category Lesson</h3>
                    </div>
                </div>
                <div class="row {{ count($populerQuiz) > 3 ? 's_cs' : '' }}">
                        @foreach ($lessonGeneral as $item)
                            <div class="col-lg-3 mb-4 col-sm-6 animated pulse">
                                <a href="{{ route('lesson.detail',['id' =>$item->id]) }}">
                                    <div class="card ht-80" style="background-color:#{{$item->color }}">
                                        <div class="card-body">
                                            <h5 class="card-title text-white">
                                                {{ $item->name }}
                                            </h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        
                        @endforeach
                </div>    
                </div>
            </div>
        </div>
        <div class="section_four pb-5">
                <div class="container">
                        <div class="row">
                            <div class="col-md-12 mb-3 mt-4">
                                <h3 class="text-black text-center p-4">{{ countByBusiness()['personal'] + countByBusiness()['business'] }} Orang Telah Bergabung</h3>
                            </div>
                            <div class="col-md-4 animated bounce">
                                <div class="media bg-pink shadow">
                                    <img src="{{ url('v1/images/defaults/59981.jpg') }}" class="wd-80" alt="">
                                    <div class="media-body text-white pt-3 pl-3">
                                            {{ countByBusiness()['personal'] }} Guru dan Murid menggunakan Ayo Sekolah.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 animated bounce">
                                    <div class="media bg-purple shadow">
                                        <img src="{{ url('v1/images/defaults/59981.jpg') }}" class="wd-80" alt="">
                                        <div class="media-body text-white pt-3 pl-3">
                                        {{ countByBusiness()['business'] }} Akun Bisnis telah menggunakan Ayo Sekolah.
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-4 animated bounce">
                                    <div class="media bg-teal shadow">
                                        <img src="{{ url('v1/images/defaults/59981.jpg') }}" class="wd-80" alt="">
                                        <div class="media-body text-white pt-3 pl-3">
                                        {{ countByBusiness()['quiz'] }} Quiz yang bisa anda Mainkan di Ayo Sekolah.
                                        </div>
                                    </div>
                            </div>
                        </div>    
                </div>
            </div>
    @endsection
    @section('footer')
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
            <script>
                $('.s_c').slick({
                    dots: false,
                    infinite: true,
                    arrows : true,
                    speed: 700,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                        },
                        {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            infinite: true,
                            arrows: true,
                        }
                        },
                        {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            infinite: true,
                            arrows: true,
                        }
                        }
                    ]
                });
            </script>
    @endsection
@show