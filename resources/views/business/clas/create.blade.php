@extends('business.layout')
    @section('header')
        <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <title> Create new a classes | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1"> Create new a classes</h4>
                </div>
            </div>
            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                    <div class="card card-body">
                        <form action="{{ route('business.clas.store') }}" method="POST" data-parsley-validate>
                            @csrf
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="d-block">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter your Class Name" name="name" required>
                            @if ($errors->has('name'))
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $errors->first('name') }}.</li>
                            </ul>
                            @endif
                        </div>
                        <a class="btn btn-secondary text-white" href="{{ route('business.clas.index')}}"><i class="fas fa-angle-left"></i> Back To Classes</a>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
                        </form>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->   
    @endsection
    @section('footer')
        <script src="{!! asset('v1/lib/parsleyjs/parsley.min.js') !!}"></script>
    @endsection
@show