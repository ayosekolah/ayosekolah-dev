@extends('personal.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
        <title>My Quizzes | {{env('APP_NAME','Ayo Sekolah') }}</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1">My Quiz </h4>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-md-12">
               <div class="row">
                @foreach ($quiz as $item)
                <a href="{{ url('personal/my_quiz/edit/'.$item->id) }}" class="col-md-6" >
                    <div class="media rounded shadow-sm mb-3 bd bd-1 bg-white">
                            <img src="{{ Storage::url($item->image) }}" class="wd-200 rounded mg-r-20" alt="">
                            <div class="media-body pt-2">
                                <h5 class="mg-b-15 tx-inverse">{{ $item->title }}  
                                    <span class="mr-2 float-right badge  {{ $item->is_active == 1 ? "badge-success" : "badge-danger" }}">{{ $item->is_active == 1 ? "Publish" : "Draft" }} </h5>         
                                <span class="tx-purple tx-bold">{{ $item->quizQuestion->count() }} Question</span> | 
                                Code :  <span class="badge badge-info tx-bold p-1">{{ $item->id }}</span>
                                <br>
                                <span class="badge badge-light mt-2">{{ $item->created_at->format('D, d/m/Y') }}</span><br>
                            </div>
                        </div>
                        </a>
                @endforeach
                <div class="col-md-12">
                    {{ $quiz->links() }}
                </div>
            </div>
            </div>
        </div><!-- row -->
</div><!-- container -->   
    @endsection
@show