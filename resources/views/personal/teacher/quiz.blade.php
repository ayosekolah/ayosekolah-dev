@extends('personal.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
        <title>My Quizzes by Class | {{env('APP_NAME','Ayo Sekolah') }}</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1">My Quiz by Clas {{ $businesId == "" ?"": "For class " .$busines->name  }}</h4>
            <a class="tx-pink" href="{{ url('personal/teacher/quiz/class/all')}}"><span>Show All Quiz</span></a>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-lg-8 col-xl-9 ">
                @foreach ($quiz as $item)
                <a href="{{ url('personal/teacher/quiz/class/edit/'.$item->id) }}">
                    <div class="media rounded shadow-sm mb-3 bd bd-1 bg-white">
                            <img src="{{ Storage::url($item->image) }}" class="wd-200 rounded mg-r-20" alt="">
                            <div class="media-body pt-2">
                                <h5 class="mg-b-15 tx-inverse">{{ $item->title }}  <span class="mr-2 float-right badge  {{ $item->is_active == 1 ? "badge-success" : "badge-danger" }}">{{ $item->is_active == 1 ? "Publish" : "Draft" }} </h5>         
                                <span class="tx-purple tx-bold">{{ $item->quizQuestion->count() }} Question</span> For Clas <span class="tx-info tx-bold"> {{ $item->busines->name }}</span><br>
                                <span class="badge badge-light mt-2">{{ $item->created_at->format('D, d/m/Y') }}</span>
                            </div>
                        </div>
                        </a>
                @endforeach
                {{ count($quiz) > 0 ? $quiz->links():"" }}
            </div>
            <div class="col-sm-7 col-md-5 col-lg-4 col-xl-3 mg-t-40 mg-lg-t-0 pl-5">
            <div class="d-flex align-items-center justify-content-between mg-b-20">
            <h6 class="tx-uppercase tx-semibold mg-b-0">Your Busines</h6>
            </div>
                @foreach ($quiz as $item)
                <ul class="list-unstyled media-list mg-b-15">
                <li class="media align-items-center">
                        <div class="wd-40 ht-40 bg-dark tx-white d-flex align-items-center justify-content-center rounded">
                        <i data-feather="calendar"></i>
                        </div>
                        <div class="media-body pd-l-15">
                        <h6 class="mg-b-2">
                            <a href="{{ url('personal/teacher/quiz/class/all?busines_id='.$item->busines->id)}}" class="link-01">
                                {{ $item->busines->name }} </a>
                            </h6>
                        <span class="tx-13 tx-color-03">{{ $item->count() }}</span>
                        </div>
                    </li>
                </ul>
                @endforeach
           
            </div>
        </div><!-- row -->
</div><!-- container -->   
    @endsection
@show