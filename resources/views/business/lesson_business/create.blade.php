@extends('business.layout')
    @section('header')
        <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('v1/lib/spectrum-colorpicker/spectrum.css') !!}" rel="stylesheet">
        <title> Create New a Lesson | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1"> Create New a Lesson</h4>
                </div>
            </div>
            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                    <div class="card card-body">
                        <form action="{{ route('business.lesson_business.store') }}" method="POST" data-parsley-validate>
                            @csrf
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="d-block">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter Lesson Name" name="name" required>
                            @if ($errors->has('name'))
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $errors->first('name') }}.</li>
                            </ul>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="d-block">Color</label>
                            <input type="text" class="form-control {{ $errors->has('color') ? ' is-invalid' : '' }}" placeholder="Enter Color Code" name="color" id="showAlpha" required>
                            @if ($errors->has('color'))
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $errors->first('color') }}.</li>
                            </ul>
                            @endif
                        </div>
                        <a class="btn btn-secondary text-white" href="{{ route('business.lesson_business.index')}}"><i class="fas fa-angle-left"></i> Back To Lesson</a>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
                        </form>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
    </div><!-- container -->   
    @endsection
    @section('footer')
        <script src="{!! asset('v1/lib/parsleyjs/parsley.min.js') !!}"></script>
        <script src="{!! asset('v1/lib/spectrum-colorpicker/spectrum.js') !!}"></script>
        <script>
           $('#showAlpha').spectrum({
          color: 'rgba(23,162,184,0.5)',
          showAlpha: true
        });
        </script>
    @endsection
@show