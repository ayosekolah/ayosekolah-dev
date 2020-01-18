@extends('personal.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
        <title>Score activity by Class | {{env('APP_NAME','Ayo Sekolah') }}</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1">Score activity by Class</h4>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-lg-8 col-xl-9 ">
                @if(count($quizScore))
                @foreach ($quizScore as $item)
                    <div class="media rounded shadow-sm mb-3 bd bd-1 bg-white">
                            <img src="{{ getImg($item->quiz->image) }}" class="wd-200 rounded mg-r-20" alt="">
                            <div class="media-body pt-2">
                                <h5 class="mg-b-5 tx-inverse">{{ $item->quiz->title }}</h5>         
                                Is True <span class="badge badge-success">{{ $item->true }}</span> | 
                                Is false <span class="badge badge-danger pb-2">{{ $item->false }}</span><br>
                                <button class="bg-purple btn text-white"> Score : {{  $item->true / ($item->true + $item->false) * 100 }} </button>
                            </div>
                    </div>
                @endforeach
                {{ $quizScore->links() }}

                @else
                <div style="text-align: center">
                        <img src="https://image.freepik.com/free-vector/student-raising-hand-flat-vector-illustration_82574-9686.jpg" width="50%" class="img-responsive">
                        <p class="text-info">Score Not Found for you.</h3>
                    </div>
                @endif
            </div>
        </div><!-- row -->
</div><!-- container -->   
    @endsection
@show