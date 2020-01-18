@extends('business.layout')
    @section('header')
      <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
      <title>Dashboard | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
              <div>
                <h4 class="mg-b-0 tx-spacing--1">Welcome to Dashboard</h4>
              </div>
            </div>
            <div class="row row-xs">
              <div class="col-sm-6 col-lg-3">
                <div class="card card-body">
                  <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Clasess</h6>
                  <div class="d-flex d-lg-block d-xl-flex align-items-end">
                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{ countByBusiness()['class'] }}</h3>
                    <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success">Classes </p>
                  </div>
                  <div class="chart-three">
                      <div id="flotChart3" class="flot-chart ht-30"></div>
                    </div><!-- chart-three -->
                </div>
              </div><!-- col -->
              <div class="col-sm-6 col-lg-3 mg-t-10 mg-sm-t-0">
                <div class="card card-body">
                  <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Lesson</h6>
                  <div class="d-flex d-lg-block d-xl-flex align-items-end">
                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{ countByBusiness()['lesbi'] }}</h3>
                    <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-danger"> Lesson</p>
                  </div>
                  <div class="chart-three">
                      <div id="flotChart4" class="flot-chart ht-30"></div>
                    </div><!-- chart-three -->
                </div>
              </div><!-- col -->
              <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                <div class="card card-body">
                  <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Teacher</h6>
                  <div class="d-flex d-lg-block d-xl-flex align-items-end">
                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{ countByBusiness()['teacher'] }}</h3>
                    <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-danger"> Teacher</p>
                  </div>
                  <div class="chart-three">
                      <div id="flotChart5" class="flot-chart ht-30"></div>
                    </div><!-- chart-three -->
                </div>
              </div><!-- col -->
              <div class="col-sm-6 col-lg-3 mg-t-10 mg-lg-t-0">
                <div class="card card-body">
                  <h6 class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8">Student</h6>
                  <div class="d-flex d-lg-block d-xl-flex align-items-end">
                    <h3 class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1">{{ countByBusiness()['student'] }}</h3>
                    <p class="tx-11 tx-color-03 mg-b-0"><span class="tx-medium tx-success"> Student</p>
                  </div>
                  <div class="chart-three">
                      <div id="flotChart6" class="flot-chart ht-30"></div>
                    </div><!-- chart-three -->
                </div>
              </div><!-- col -->
            </div><!-- row -->
          </div><!-- container -->   
    @endsection
@show