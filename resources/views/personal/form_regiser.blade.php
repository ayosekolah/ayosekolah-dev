@extends('personal.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">  
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet"> 
        <title>Join Teacher| {{ env('APP_NAME','') }}</title>
        <style>
            .image-upload > input
            {
                display: none;
            }
            .image-upload img
            {
                width: 200px;
                cursor: pointer;
            }
        </style>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Teacher</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Join to Teacher </h4>
                </div>
            </div>
            <div class="row row-xs">
                <div class="col-sm-8 col-lg-8">
                    <div class="card card-body">
                        <form action="{{ route('personal.join.proccess') }}" method="POST"   enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                        <input type="hidden" name="type" value="{{ Request::segment(3) }}">
                        <input type="hidden" name="busines_id" value="{{ $busines_id }}">
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="d-block">Name</label>
                            <input readonly type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter Lesson Name" value="{{ Auth::guard('personal')->user()->name }}" required>
                            @if ($errors->has('name'))
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $errors->first('name') }}.</li>
                            </ul>
                            @endif
                        </div>
                        <div class="form-group">
                                <label for="formGroupExampleInput" class="d-block">Email</label>
                                <input readonly type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ Auth::guard('personal')->user()->email }}" required>
                                @if ($errors->has('name'))
                                <ul class="parsley-errors-list filled" id="parsley-id-5">
                                    <li class="parsley-required">{{ $errors->first('name') }}.</li>
                                </ul>
                                @endif
                        </div>
                        <div class="form-group">
                                <label for="formGroupExampleInput" class="d-block">Phone Number</label>
                                <input type="number" min="1" name="phone" class="form-control" value="{{ Auth::guard('personal')->user()->phone }}" placeholder="Enter Your Phone Number" required>
                                @if ($errors->has('phone'))
                                <ul class="parsley-errors-list filled" id="parsley-id-5">
                                    <li class="parsley-required">{{ $errors->first('phone') }}.</li>
                                </ul>
                                @endif
                        </div>
                        <div class="form-group">
                                <label for="formGroupExampleInput" class="d-block">Birth of date</label>
                                <input name="birth_of_date" id="bod" class="form-control" placeholder="Enter Your Birth of Date" value="{{ date('m/d/Y',strtotime(Auth::guard('personal')->user()->birth_of_date)) }}" required>
                                @if ($errors->has('birth_of_date'))
                                <ul class="parsley-errors-list filled" id="parsley-id-5">
                                    <li class="parsley-required">{{ $errors->first('birth_of_date') }}.</li>
                                </ul>
                                @endif
                        </div>
                        <div class="form-group">
                                <label for="formGroupExampleInput" class="d-block">Address</label>
                                <textarea name="address" id="" cols="30" rows="3" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter you Address" required>{{Auth::guard('personal')->user()->address }}</textarea>
                                @if ($errors->has('name'))
                                <ul class="parsley-errors-list filled" id="parsley-id-5">
                                    <li class="parsley-required">{{ $errors->first('name') }}.</li>
                                </ul>
                                @endif
                        </div>
                        <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                            <label for="formGroupExampleInput" class="d-block">Image</label>
                                            <div class="image-upload">
                                                    <label for="profile-img">
                                                        <img  id="profile-img-tag" src="{{ getImg(Auth::guard('personal')->user()->image) }}" width="500px" class="img-thumbnail"/>
                                                    </label>
                                                    <input type="hidden" name="imageOld" value="{{ Auth::guard('personal')->user()->image }}">
                                                    <input id="profile-img" type="file" name="images" class="form-control"/>
                                            </div>
                                            
                                    </div>
                                </div>
                        </div>
                        
                        <a class="btn btn-secondary text-white" href="{{ url('personal/join/') }}"><i class="fas fa-angle-left"></i> Back</a>
                        <button class="btn text-white bg-purple" type="submit"><i class="fas fa-check"></i> Save</button>
                        </form>
                    </div>
                </div><!-- col -->
                <div class="col-sm-4 col-lg-4">
                        <img src="{{ url('v1/images/defaults/join-image.jpeg') }}" class="img-responsive" width="400px" alt="">
                </div>
            </div><!-- row -->
    </div><!-- container -->   
    @endsection
    @section('footer')
    <script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/jqueryui/jquery-ui.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/prismjs/prism.js') !!}"></script>
    <script src="{!! asset('v1/lib/parsleyjs/parsley.min.js') !!}"></script>
    <script>
    $('.select2').select2({
          placeholder: 'Choose Lesson',
          searchInputPlaceholder: 'Search options'
    });
    $('.clas_select').select2({
          placeholder: 'Choose Class',
          searchInputPlaceholder: 'Search options'
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-img").change(function(){
        readURL(this);
    });
    $('#bod').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true
    });
    
</script>
    @endsection
@show