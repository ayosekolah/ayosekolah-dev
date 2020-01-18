@extends('personal.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
        <title>Quiz by Class | {{env('APP_NAME','Ayo Sekolah') }}</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1">My Quiz by Clas</h4>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-md-12">
                @if(count($quiz))
                <div class="row">
                @foreach ($quiz as $item)
                <a href="{{ url('personal/student/quiz/class/answer/'.$item->id) }}" class="col-md-6 ">
                    <div class="media rounded shadow-sm mb-3 bd bd-1 bg-white">
                            <img src="{{ Storage::url($item->image) }}" class="wd-200 rounded mg-r-20" alt="">
                            <div class="media-body pt-2">
                                <h5 class="mg-b-15 tx-inverse">{{ $item->title }}   </h5>         
                                <span class="tx-purple tx-bold">{{ $item->quizQuestion->count() }} Question</span> by <span class="tx-info tx-bold"> {{ $item->teacher->name }}</span><br>
                                <span class="badge badge-light mt-2">{{ $item->created_at->format('D, d/m/Y') }}</span>
                            </div>
                        </div>
                        </a>
                @endforeach
                </div>
                {{ $quiz->links() }}

                @else
                <div style="text-align: center">
                        <img src="https://image.freepik.com/free-vector/student-raising-hand-flat-vector-illustration_82574-9686.jpg" width="50%" class="img-responsive">
                        <p class="text-info">Quiz Not Found for you.</h3>
                    </div>
                @endif
            </div>
        </div><!-- row -->
</div><!-- container -->   
    @endsection
@show