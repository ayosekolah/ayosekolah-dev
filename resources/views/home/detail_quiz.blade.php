@extends('home.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
        <title>My Quizzes | {{env('APP_NAME','Ayo Sekolah') }}</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1">Detail Quiz </h4>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-md-12">
                        @include('_partial.alert')
                        
            </div>
            <div class="col-lg-12 col-xl-9 ">
                    <div class="media rounded shadow-sm mb-3 bd bd-1">
                        <div class="row">
                            <div class="col-md-12">
                            <img src="{{ Storage::url($quiz->image) }}" class=" rounded bd mg-r-30 img-responsive img-fluid" alt="">
                            </div>
                            <div class="col-md-12 m-3">
                                <div class="media-body pt-2 p-2 mt-1">
                                    <h5 class="mg-b-5 tx-inverse">{{ $quiz->title }} </h5>      
                                    <span class="tx-purple tx-bold">{{ $quiz->quizQuestion->count() }} Question</span><br>
                                    <span class="badge badge-light mt-2">{{ $quiz->created_at->format('D, d/m/Y') }}</span><br><br>
                                    @if(Auth::guard('personal')->check() && $quiz->teacher_id == Auth::guard('personal')->user()->id)
                                    <button type="submit" class="btn btn-danger" disabled>It's Your Quiz</button>
                                    @else
                                    @if(Auth::guard('personal')->check())
                                        <a href="{{ url('/play_quiz/'.$quiz->id) }}" class="btn bg-purple text-white mt-3"> Play this quiz</a> 
                                    @else
                                    <button type="button" class="btn bg-purple text-white mt-3" data-toggle="modal" data-target="#play_quiz">
                                            Play this quiz
                                    </button>
                                    @endif
                                    <div class="modal fade" id="play_quiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Create your Username</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('play_quiz/'.$quiz->id) }}" method="GET">
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Username</label>
                                                <input type="text" class="form-control" name="username" placeholder="Enter your Username / Nickname">
                                            </div>                                       
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            @if(Auth::guard('personal')->check() && $quiz->teacher_id == Auth::guard('personal')->user()->id)
                                            <button type="submit" class="btn btn-primary" disabled>It's Your Quiz</button>
                                            @else
                                            <button type="submit" class="btn btn-primary">Play Now</button>
                                            @endif
                                        </div>
                                        </div>
                                    </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <p class="pl-4 pr-3">{{ $quiz->description }}</p>   
                            </div>
                                @endif
                            </div>
                    </div>
            </div>
        </div><!-- row -->
</div><!-- container -->   
    @endsection
@show