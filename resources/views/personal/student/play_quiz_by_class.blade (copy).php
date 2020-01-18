@extends('personal.layout')
@section('header')
<link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">
<link rel="stylesheet" type="text/css" href=" {{ asset('v1/lib/quiz/jquery.quiz-min.css') }}" />
<script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
@endsection
@section('contents')
<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Quiz</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">My Quiz by Clas</h4>
        </div>
    </div>
    <div class="row row-xs">
        <div class="col-md-12">
            @include('_partial.alert')
        </div>
        <div class="col-lg-12 col-xl-12 bg-pink text-white">
            <div class="container">
                <div id="quiz">
                    <div id="quiz-header">
                        <h1>Basic Quiz Demo</h1>
                        <p><a href="{{ url('personal/student/quiz/class/all') }}" id="quiz-home-btn">Home</a></p>
                    </div>
                    <div id="quiz-start-screen">
                        <p><a href="#" id="quiz-start-btn" class="quiz-button">Start</a></p>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- row -->
</div><!-- container -->
@endsection
@section('footer')
<script src="{!! asset('v1/lib/quiz/jquery.quiz-min.js') !!}"></script>
<script>
    // var datas = ''
    $.ajax({
        url: 'http://lms.pro/personal/student/quiz/class/answer/get_data_play/3',
        dataType: 'json',
        data: '',
        success: function(data, status, xhr) {
            $('#quiz').quiz({
                resultsScreen: '#results-screen',
                counter: false,
                //homeButton: '#custom-home',
                counterFormat: 'Question %current of %total',
                questions: data
            });
            setTimeout(function() {
                alert('Waktu Habis');
            }, 1000);
        },
        error: function(xhr, status, error) {
            alert(status);
        }
    });
</script>
@endsection
@show