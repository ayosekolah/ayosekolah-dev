@extends('personal.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between">
              <div>
                <h4 class="mg-b-0">List Business</h4>
              </div>
              {{-- <div class="search-form mg-t-20 mg-sm-t-0">
                <input type="search" class="form-control" placeholder="Search groups">
                <button class="btn" type="button"><i data-feather="search"></i></button>
              </div> --}}
            </div>
          </div>
          <br><hr>
    <div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="row row-xs mg-b-25">
                    @foreach ($business as $item)
                    <div class="col-sm-6 col-md-3">
                            <div class="card card-profile">
                              <img src="https://via.placeholder.com/500/8e44ad/8e44ad" class="card-img-top" alt="">
                              <div class="card-body tx-13">
                                <div>
                                    <div class="avatar avatar-xl"><img src="{{ getImg($item->image) }}" class="rounded-circle" alt=""></div>
                                  <h5><a href="">{{ $item->name }}</a></h5>
                                  <p>{{ $item->clas->count() }} Clas</p> 
                            
                                  <div class="dropdown dropright">
                                        <button class="btn btn-block btn-white dropdown-toggle" type="button" id="droprightMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Join
                                        </button>
                                        <div class="dropdown-menu tx-13" aria-labelledby="droprightMenuButton">
                                            <a class="dropdown-item" href="{{ url('/personal/join/teacher/now/'.$item->id) }}">Teacher</a>
                                            <a class="dropdown-item" href="{{ url('/personal/join/student/now/'.$item->id) }}">Student</a>
                                        </div>
                                </div>
                                </div>
                              </div>
                            </div><!-- card -->
                          </div><!-- col -->
                    @endforeach
                </div><!-- row -->
                <div class="row">
                        <div class="col-lg-12">
                        {{ $business->links() }}
                        </div>
                </div>
              </div><!-- col -->
            </div><!-- row -->
          </div><!-- container -->
    </div>
    @endsection
@show