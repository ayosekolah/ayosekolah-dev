@extends('personal.template_quiz')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
        <link rel="stylesheet" type="text/css" href=" {{ asset('v1/lib/quiz/jquery.quiz-min.css') }}" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="{{ asset('v1/lib/animate.css/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('v1/custom/css/quiz-answer.css') }}" rel="stylesheet">
        <title>Play Quiz | {{env('APP_NAME','Ayo Sekolah') }}</title>
        <script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
    @endsection
    @section('contents')
    <?php $background_colors = array('#1abc9c', '#3498db', '#9b59b6', '#e67e22', '#e74c3c','#3498db','#f1c40f',
    '#ff00ff','#bada55','#ff80ed','#fa8072','#c39797','#fa8072','#f08080','#00ced1'); ?>
        <div class="">
            <div class="col-md-12">
                        @include('_partial.alert')
                        
            </div>
            <div class="col-lg-12 col-xl-12 text-white quiz_wrapper qz">
                @if(isset($_GET['participant_id']))
                <form action="{{ url('personal/student/quiz/class/answer/get_data_play/?quiz_id='.$quiz->id.'&participant_id='.$_GET['participant_id']) }}" method="POST">
                @csrf
                <div class="container-fluid quiz ">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                    <?php $x = 1; ?>
                                    @foreach ($questions as $index => $item)
                                    <div class="carousel-item middle {{ $index != 0?: 'active' }} ">
                                        <div class="qustion_header">
                                        @if($item->question == "")
                                        <h1 class="text-center text-white animated fadeInDown  mb-5 question_title">
                                            <img src="{{ getImg($item->image) }}" class="img img-responsive img-fluid" width="420px">
                                        </h1>
                                        @elseif($item->image == "")
                                            <h1 class="text-center text-white animated fadeInDown  mb-5 question_title">{!! $item->question !!}</h1>
                                        @else
                                            <div class="row with_image">
                                                <div class="col-md-12">
                                                    <img src="{{ getImg($item->image) }}" class="img img-responsive img-fluid img_title" width="350px">
                                                </div>
                                                <div class="col-md-12 pt-4">
                                                    <h1 class="text-center text-white animated fadeInDown  mb-5 question_title">{!! $item->question !!}</h1>
                                                </div>
                                            </div>
                                        @endif
                                        <input type="hidden" id="question_index" value="{{ $item->id }}" name="question[{{$item->id}}]">
                                    </div>
                                        @foreach ($item->quizQuestionAnswer as $index_a => $item_answer)
                                        <label class="answer_la">
                                                <input id="{{$item_answer->id }}" type="radio" name="answer[{{$item->id}}]['q']" value="{{$item_answer->id }}" {{ $index_a == 0 ?'' : '' }} required />
                                                <div onclick="xOke({{$item_answer->id}})"  data-target="#carouselExampleControls" data-slide-to="{{$x}}"   class="back-end box rounded-5 bd"  style="background:{{ $background_colors[array_rand($background_colors)] }}" >
                                                    <span id="chev" >
                                                        @if($item_answer->answer == "")
                                                            <img src="{{ Storage::url($item_answer->image) }}"class="img img-responsive img-fluid img_ans rounded-5" width="90px">
                                                        @else
                                                            <div class="mathet" style="{{sizeFont(strlen($item_answer->answer))}}">
                                                            {!!  $item_answer->answer  !!}
                                                            </div>
                                                        @endif
                                                    </span>
                                                </label>
                                        </div>
                                        @endforeach
                                        <?php $x++ ;?>
                                    </div>
                                    @endforeach
                        </div>
                        <div id="" class="carousel-indicators" style="bottom:10px !important;position:fixed;z-index:100000;overflow: scoll; display: flex;max-width: 100%;">
                                @foreach ($questions as $index => $item)
                                    <span onclick="checkNumber()" class="{{ $index != 0?: 'active' }} m-1" style="float:left">
                                    <a data-target="#carouselExampleControls" data-slide-to="{{$index}}" class="btn btn-circle justify-content-center align-items-center xp tx-bold">
                                            {{ $index + 1 }}
                                    </a>
                                    </span>
                                @endforeach
                        </div>
                </div>
                <div class="text-center fixed-bottom pb-5 pt-5 buttom_action bg-black-1" style="padding-bottom:100px !important">
                    <a href="{{ url('/') }}" class="btn btn-outline-warning cancel_ques btn-lg">Cancel</a>
                    <button  id="prev" href="#" class="btn btn-info btn-lg " >Prev</button>
                    <button id="next"  href="#" class="btn btn-lg btn-success">Next</button>
                </div>
            </div>
            </form>
            @else
            <div class="container h-100">
                    <div class="row h-100 justify-content-center align-items-center">
                        <div class="col-12 text-center ">
                            <h1 class="text-white">{{ $quiz->title }}</h1><br>
                            <a href="{{ url('personal/dashboard') }}" class="btn btn-outline-success btn-lg tx-20">Back to Quiz</a>
                            <a href={{ url('personal/student/quiz/class/answer/'.Request::segment(6). '?participant_id='.Auth::guard("personal")->user()->id) }} class="tx-20 btn btn-primary btn-lg animated heartBeat">Start Quiz</a>
                        </div>   
                    </div>
            </div>
            @endif
        </div>
    @endsection
    @section('footer')
    <script src="{!! asset('v1/lib/quiz/jquery.quiz-min.js') !!}"></script>
    <script>
    $("math").attr("mathcolor", "white");
    $("math").attr("class", "img-fluid");
    // $("math").attr("style" ,"height:100px !important !important");
    $('#carouselExampleControls').carousel({
        interval: false
    })

    currentIndex = $('div.active').index() ;
    if(currentIndex == 0){
        document.getElementById("prev").disabled = true;
    }
    
    $("#next").click(function(e){
        currentIndex = $('div.active').index() ;
        if(currentIndex == {{$questions->count() - 2 }}){
            document.getElementById("next").disabled = true;
            $(".buttom_action").append("<button type='submit' class='save_quiz  btn btn-lg btn-primary'  >Save</a>")
        }
        e.preventDefault()
        $("#carouselExampleControls").carousel("next");
        document.getElementById("prev").disabled = false;
    });
    $("#prev").click(function(e){
        $(".save_quiz").remove()
        currentIndex = $('div.active').index() ;
        if(currentIndex == 0){
            document.getElementById("prev").disabled = true;
        }
        e.preventDefault()
        $("#carouselExampleControls").carousel("prev");
        document.getElementById("next").disabled = false;
    });
    function xOke(id){
            
            $('#'+id).attr('checked', 'checked');
            currentIndex = $('div.active').index() ;
            if(currentIndex == {{$questions->count() -1 }}){
                $(".save_quiz").remove()
                $(".buttom_action").append("<button type='submit' class='save_quiz  btn btn-lg btn-primary'  >Save</a>")
                    document.getElementById("next").disabled = true;
                    document.getElementById("prev").disabled = false;
            }else if(currentIndex == 0  ){
                    document.getElementById("next").disabled = false;
                    document.getElementById("prev").disabled = true;
            }else{
                    document.getElementById("next").disabled = false;
                    document.getElementById("prev").disabled = false;
            }
    }
    function checkNumber(id){   
            $(".save_quiz").remove()
            currentIndex = $('div.active').index() ;
            if(currentIndex  == {{$questions->count() - 1}}){
                $(".buttom_action").append("<button type='submit' class='save_quiz  btn btn-lg btn-primary'  >Save</a>")
                    document.getElementById("next").disabled = true;
                    document.getElementById("prev").disabled = false;
            }
            else if(currentIndex > 0 && currentIndex <   {{$questions->count()}}){
                    document.getElementById("next").disabled = false;
                    document.getElementById("prev").disabled = false;
                    $(".save_quiz").remove()
            }else{
                    document.getElementById("next").disabled = false;
                    document.getElementById("prev").disabled = false;
                    $(".save_quiz").remove()
            }
    }
    </script>
    @endsection
@show