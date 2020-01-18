@extends('personal.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
        <title>My Quizzes | {{env('APP_NAME','Ayo Sekolah') }}</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1">My Quiz Report </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-lg-12 col-xl-12">
                <div class="row">
                    @if($quiz->count() > 0)
                    @foreach ($quiz as $item)
                        <div class="col-md-6 ">
                            <div class="media rounded shadow-sm mb-3 bd bd-1 bg-white">
                                    <img src="{{ Storage::url($item->image) }}" class="wd-200 rounded mg-r-20" alt="">
                                    <div class="media-body pt-2">
                                        <h5 class="mg-b-15 tx-inverse">{{ $item->title }}  
                                            <a href="{{ url('quiz/general/report/'.$item->id) }}">
                                                <span class="mr-1 float-right btn btn-info btn-sm">Show Report
                                            </a> 
                                            </h5>         
                                        <span class="tx-purple tx-bold">{{ $item->quizQuestion->count() }} Question</span><br>
                                        <span class="badge badge-light mt-2">{{ $item->created_at->format('D, d/m/Y') }}</span>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12">
                    {{ $quiz->links() }}
                </div>
                @else
                <div style="text-align: center">
                        <img src="https://image.freepik.com/free-vector/student-raising-hand-flat-vector-illustration_82574-9686.jpg" width="50%" class="img-responsive">
                        <p class="text-info">Report Not Found</h3>
                </div>
                @endif
            </div>
        </div><!-- row -->
</div><!-- container -->   
    @endsection
@show