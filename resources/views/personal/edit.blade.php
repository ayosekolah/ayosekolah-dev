@extends('personal.layout')
    @section('header')
    <title> Edit Profil | Ayo Sekolah</title>
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
    <link rel="stylesheet" type="text/css" href=" {{ asset('v1/lib/quiz/jquery.quiz-min.css') }}" />
    <script src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('v1/lib/animate.css/animate.min.css') }}" rel="stylesheet">
    <style>
        .image-upload > input
        {
            display: none;
        }
        .image-upload img
        {
            width: 200px;
        }
    </style>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1" id="x">Edit Profil</h4>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-sm-12 col-lg-12 mb-4">
                <div class="card card-body h-100  shadow-sm">
                    <form  method="POST" action="{{ route('personal.update') }}" class="row" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-7">
                            <fieldset class="form-fieldset">
                                    <legend>Personal Information</legend>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput" class="d-block">Username</label>
                                            <input type="text" name="username" value="{{ $personal->username }}" class="form-control" placeholder="Enter your username">
                                            @if ($errors->has('username'))
                                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                <li class="parsley-required">{{ $errors->first('username') }}.</li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                                <label for="formGroupExampleInput" class="d-block">Name</label>
                                                <input type="text" name="name" value="{{ $personal->name }}" class="form-control">
                                                @if ($errors->has('name'))
                                                <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                    <li class="parsley-required">{{ $errors->first('name') }}.</li>
                                                </ul>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput" class="d-block">Email</label>
                                            <input type="text" name="email" value="{{ $personal->email }}" class="form-control">
                                            @if ($errors->has('email'))
                                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                <li class="parsley-required">{{ $errors->first('email') }}.</li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                                <label for="formGroupExampleInput" class="d-block">Birth of date</label>
                                                <input name="birth_of_date" id="bod" class="form-control" placeholder="Enter Your Birth of Date" value="{{ date('d/m/Y', strtotime($personal->birth_of_date)) }}" >
                                                @if ($errors->has('birth_of_date'))
                                                <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                    <li class="parsley-required">{{ $errors->first('birth_of_date') }}.</li>
                                                </ul>
                                                @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput" class="d-block">Phone</label>
                                            <input type="number" min="1" minlength="10"  name="phone" value="{{ $personal->phone }}" class="form-control"  placeholder="Enter your Phone Number">
                                            @if ($errors->has('phone'))
                                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                <li class="parsley-required">{{ $errors->first('phone') }}.</li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput" class="d-block">Fax</label>
                                            <input type="number" min="1" minlength="1"  name="fax" value="{{ $personal->fax }}" placeholder="Enter your Fax Number" class="form-control">
                                            @if ($errors->has('fax'))
                                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                <li class="parsley-required">{{ $errors->first('fax') }}.</li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput" class="d-block">Address</label>
                                            <textarea name="address"  cols="30" rows="5" class="form-control" placeholder="Enter your Address">{{$personal->address}}</textarea>
                                            @if ($errors->has('address'))
                                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                <li class="parsley-required">{{ $errors->first('address') }}.</li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                        <label for="formGroupExampleInput" class="d-block">Image</label>
                                                        <div class="image-upload">
                                                                <label for="profile-img">
                                                                    <img  id="profile-img-tag" src="{{ getImg($personal->image) }}" width="500px" class="img-thumbnail"/>
                                                                    <figcaption class="pos-absolute b-0 l-0 wd-100p pd-25 d-flex justify-content-center">
                                                                            <div class="btn btn-sm btn-light"> Change</div>
                                                                        </figcaption>
                                                                </label>
                                                                <input id="profile-img" type="file" name="image" class="form-control"/>
                                                                
                                                        </div>
                                                        
                                                </div>
                                            </div>
                                        </div>
                            </fieldset>
                        </div>
                        <div class="col-md-5">
                                <fieldset class="form-fieldset">
                                        <legend>Change Password</legend>
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="password" class="form-control" placeholder="Masukkan kata sandi lama" name="old_password">
                                                @if ($errors->has('old_password'))
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                        <li class="parsley-required">{{ $errors->first('old_password') }}.</li>
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="password" class="form-control" placeholder="Masukkan kata sandi baru" name="new_password">
                                                @if ($errors->has('new_password'))
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                        <li class="parsley-required">{{ $errors->first('new_password') }}.</li>
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Confirm New Password</label>
                                                <input type="password" class="form-control" placeholder="Ulangi kata sandi baru" name="confirm_password">
                                                @if ($errors->has('confirm_password'))
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                        <li class="parsley-required">{{ $errors->first('confirm_password') }}.</li>
                                                    </ul>
                                                @endif
                                            </div>
                                </fieldset>
                                <br>
                                <div class="text-right">
                                    <a href="{{ url('personal/dashboard')}}" class="btn btn-light text-black">Back</a>
                                    <button type="submit" class="btn btn-info">Update Information</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- container -->   
    @endsection
    @section('footer')
    <script src="{!! asset('v1/lib/jqueryui/jquery-ui.min.js') !!}"></script>
    <script>
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