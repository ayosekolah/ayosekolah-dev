@extends('personal.layout')
    @section('header')
    <title> Dashboard | Ayo Sekolah</title>
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
    <link rel="stylesheet" type="text/css" href=" {{ asset('v1/lib/quiz/jquery.quiz-min.css') }}" />
    <script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('v1/lib/animate.css/animate.min.css') }}" rel="stylesheet">
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1" id="x">Dashboard </h4>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-sm-7 col-lg-7 mb-4">
                <div class="card card-body h-100 justify-content-center align-items-center shadow-sm">
                    <form action="" id="join">
                            <div class="input-group">
                            <input type="text" class="form-control" placeholder="Find with code" aria-label="Recipient's username" aria-describedby="button-addon2" name="code">
                            <div class="input-group-append">
                                <button class="btn btn-outline-light" type="submit" id="button-addon2">Join</button>
                            </div>
                            </div>
                    </form>
                </div>
            </div><!-- col -->
            <div class="col-sm-5 col-lg-5 text-center mb-4">
                <div class="card card-body shadow-sm text-center justify-content-center align-items-center">
                    <div class="avatar avatar-xl">
                        <img class="rounded-circle text-center" src="{{ getImg(Auth::guard('personal')->user()->image) }}" alt=""  width="100">
                    </div>
                    <h3 class="pt-3 tx-16">{{ Auth::guard('personal')->user()->name }}</h3>
                    <a href="{{ route('personal.edit') }}">Edit</a>
                </div>
            </div><!-- col -->
        </div><!-- row -->
        <div class="row">
                <div class="col-md-12 mb-3">
                    <h3 class="text-center p-4">List your Business</h3>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        @foreach ($busines as $index => $item)
                        <div class="col-md-3 mb-4 pt-4">
                                <div class="card animated pulse shadow-sm">
                                <img src="{{ getImg($item->image) }}" class="card-img-top  ht-150" alt="...">
                                    <div class="card-body ">
                                        <h6 class="card-title">{{ $item->busines->name }} </h6>
                                        <span class="text-{{ $item->type == "teacher" ? "info" : "success" }} mb-5">{{ ucfirst($item->type)}}</span> <br>
                                        @if($item->is_approve == 1)
                                            <a href="{{ route('busines.detail', ['id' => $item->id ]) }}" class="btn bg-purple text-white mt-2 btn-sm">Go Business</a> 
                                        @elseif($item->is_approve == 2)
                                            <button class="btn bg-danger text-white mt-2 btn-sm" disabled>Deleted / Canceled</button> 
                                        @else
                                            <button class="btn bg-orange text-white mt-2 btn-sm" disabled>Waiting Approve</button> 
                                        @endif
                                    </div>
                                </div>
                        </div>
                        @endforeach
                    </div>
                </div>
        </div>   
        <div class="row">
            <div class="col-md-12 mb-3">
                <h3 class="text-center p-4">Find Your Quiz</h3>
            </div>
            @foreach ($quiz as $index => $item)
            <div class="col-md-3 mb-4 ">
                    <div class="card animated pulse shadow-sm">
                    <img src="{{ getImg($item->image) }}" class="card-img-top ht-150" alt="...">
                        <div class="card-body ">
                            <h6 class="card-title">{{ $item->title }} </h6>
                            <span class="text-info mb-5">{{ $item->quizQuestion->count() }}</span> Question <br>
                            @if($item->teacherAll->id == Auth::guard('personal')->user()->id)
                                <button class="btn bg-danger text-white mt-2" disabled>It's your Quiz</button> 
                            @else
                                <a href="{{ url('detail_quiz/'.$item->code) }}" class="btn bg-purple text-white mt-2">Go Quiz</a> 
                            @endif
                        </div>
                    </div>
            </div>
            @endforeach
            <div class="col-md-12">
                {{ $quiz->links() }}
            </div>
    </div>   
    </div><!-- container -->   
    @endsection
    @section('footer')
       <script>
          $(document).ready(function(){
            $("#join").submit(function(e){
                e.preventDefault()
                id = $("input[name='code']").val();
                if(id.length == 0){
                    alert('Enter your code')
                    return false
                }
                window.location.href="{{ url('detail_quiz/')}}/" + id
            });
        });
       </script>
    @endsection
@show