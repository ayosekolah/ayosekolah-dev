@extends('home.layout')
    @section('header')
    <title> Lesson {{$lesson}} | Ayo Sekolah</title>
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
    <link rel="stylesheet" type="text/css" href=" {{ asset('v1/lib/quiz/jquery.quiz-min.css') }}" />
    <script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('v1/lib/animate.css/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://kenwheeler.github.io/slick/slick/slick-theme.css">
    <style>
        .slick-prev:before, .slick-next:before {
            color: purple;
        }
    </style>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <h4 class="mg-b-0 tx-spacing--1" id="x">Quiz for Lesson {{$lesson}} </h4>
            </div>
        </div>
        <div class="row">
            @if($listClas->count())
            <div class="col-md-12 mb-3">
                @foreach ($listClas as $item)
                    <h3 class="text-center mb-3">{{ $item->clas->name }}</h3>
                    <?php $cI = \App\Quiz::where('clas_id',$item->clas->id)->count() ;?>
                    <div class="row  {{$cI > 4 ? 's_c' : '' }}">
                    @foreach (\App\Quiz::where('clas_id',$item->clas->id)->get() as $item)
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
                @endforeach
            </div>
            @else
                   <div class="text-danger" style="width:200px;margin:0px auto">
                       Quiz Not Found.   
                       <a class="btn btn-secondary btn-xs" href="{{ url('') }}">Back</a>
                   </div>
                 
            @endif
        </div>   
    </div><!-- container -->   
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