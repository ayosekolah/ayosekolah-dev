@extends('personal.template_quiz')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
        <link rel="stylesheet" type="text/css" href=" {{ asset('v1/lib/quiz/jquery.quiz-min.css') }}" />
        <script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Quiz Score | {{env('APP_NAME','Ayo Sekolah') }}</title>
            <style>
            .content-fixed {
                padding: 0 !important;
                margin: 0 !important;
            }
            .middle {
            width: 100%;
            text-align: center;
            }
            .quiz_wrapper{
                height: 100vh;;
            }
        </style>
    @endsection
    @section('contents')
        <div class="">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-lg-12 col-xl-12 text-white quiz_wrapper" style="background:#61173b">
                <div class="container pt-5">
                <div class="row">
                    <div class="col-md-4">
                            <div class="card bg-black-1">
                                <div class="card-body text-center">
                                    <div class="img-group">
                                        @if(Auth::guard('personal')->check())
                                        <img src="{{ getImg(Auth::guard('personal')->user()->id) }}" class="img wd-60 ht-60 rounded-circle" alt="">
                                        @else
                                        <img src="{{ getImg('') }}" class="img wd-60 ht-60 rounded-circle" alt="">
                                        @endif
                                    </div>
                                    <br>
                                    <span> <b>By </b> {{ $cekScore->quiz->teacherAll->name }} </span><br><br>
                                    <span> <b>Create Date </b>{{ date('D, d-m-Y',strtotime($cekScore->quiz->teacherAll->created_at)) }} </span><br><br>
                                    <a href="{{ url('/')}}" class="btn btn-light">Back to Home</a>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card bg-black-1">
                            <div class="card-body text-center">
                                <h1 class="text-white">{{ $cekScore->title }}</h1>
                                <p class="tx-16" >Date answer :    {{ date('D, d-m-Y',strtotime($cekScore->start_date_time)) }} s.d {{ date('D, d-m-Y',strtotime($cekScore->end_date_time)) }}</p>
                                <p class="tx-16">Correct answer : <span class="badge badge-success"> {{ $cekScore->true }}</span></p>
                                <p class="tx-16">Wrong answer : <span class="badge badge-danger"> {{ $cekScore->false }}</span></p>
                                <button class="btn btn-block btn-info btn-lg tx-bold tx-20">Score : {{ $cekScore->true / ($cekScore->true + $cekScore->false) * 100 }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                            <div class="card">
                                    <div class="table-responsive">
                                        <table class="table bg-white">
                                        <tr>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>You Answer</th>
                                        </tr>
                                        @foreach ($istrue as $item)
                                        <tr>
                                            <td>
                                                @if($item->question->question == "")
                                                <img src="{{ getImg($item->question->image) }}" alt="" width="50px">
                                                @else
                                                {!! strip_tags($item->question->question) !!}
                                                @endif
                                            </td>
                                            <td> 
                                                @if ($item->question->quizQuestionAnswerEi[0]->answer =="")
                                                    <img src="{{ getImg($item->question->quizQuestionAnswerEi[0]->image) }}" alt="" width="50px">
                                                @else
                                                    {!! strip_tags($item->question->quizQuestionAnswerEi[0]->answer) !!}   
                                                @endif

                                            </td>
                                            <td>
                                                <span class=" {{ $item->is_true  == 1 ? 'text-success' :'text-danger' }}">
                                                    @if ($item->quizQuestionAnswerEi->answer =="")
                                                        <img src="{{ getImg($item->quizQuestionAnswerEi->image) }}" alt="" width="50px">
                                                    @else
                                                        {!! strip_tags($item->quizQuestionAnswerEi->answer) !!}   
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </table>       
                                    </div>
                            </div>
                        </div>
                </div>
                </div>
        </div>
    @endsection
    @section('footer')
        <script src="{!! asset('v1/lib/quiz/jquery.quiz-min.js') !!}"></script>
    @endsection
@show

