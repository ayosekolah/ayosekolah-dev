@extends('business.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <title>Invite | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1">Invite</h4>
                </div>
            </div>
            <div class="row row-xs bg-white">
                <div class="col-sm-12 col-lg-12 p-4">
                    @if($type == "student")
                        <form action="{{ url('business/invite_proccess') }}" method="POST" data-parsley-validate>
                            @csrf
                            <input type="hidden" name="id_personal" value="{{ $personal->id }}">
                            <input type="hidden" name="type" value="student">
                            <div class="form-group">
                                <label for="formGroupExampleInput" class="d-block">Name</label>
                                <input readonly type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter Name" value="{{ $personal->name }} " required>
                                @if ($errors->has('name'))
                                <ul class="parsley-errors-list filled" id="parsley-id-5">
                                    <li class="parsley-required">{{ $errors->first('name') }}.</li>
                                </ul>
                                @endif
                            </div>
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Email</label>
                                    <input readonly type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $personal->email }}" required>
                                    @if ($errors->has('email'))
                                    <ul class="parsley-errors-list filled" id="parsley-id-5">
                                        <li class="parsley-required">{{ $errors->first('email') }}.</li>
                                    </ul>
                                    @endif
                            </div>
                            <div class="form-group">
                                        <label for="formGroupExampleInput" class="d-block">Classes</label>
                                        <select class="form-control clas_select" multiple="multiple" name="clas_id[]" required>
                                            @foreach ($clas as $item)
                                                <option value="{{$item->id}}">{{$item->name }}</option>
                                            @endforeach
                                        </select>
                            </div>
                            <a class="btn btn-secondary text-white" href="{{ url('business/clas_personal/index/student?approve=1') }}"><i class="fas fa-angle-left"></i> Back</a>
                            <button class="btn text-white bg-purple" type="submit"><i class="fas fa-check"></i> Save</button>
                            </form>
                    @else
                        <form action="{{ url('business/invite_proccess') }}" method="POST" data-parsley-validate>
                            @csrf
                            <input type="hidden" name="id_personal" value="{{ $personal->id }}">
                            <input type="hidden" name="type" value="teacher">
                            <div class="form-group">
                                <label for="formGroupExampleInput" class="d-block">Name</label>
                                <input readonly type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter Name" value="{{ $personal->name }} " required>
                                @if ($errors->has('name'))
                                <ul class="parsley-errors-list filled" id="parsley-id-5">
                                    <li class="parsley-required">{{ $errors->first('name') }}.</li>
                                </ul>
                                @endif
                            </div>
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Email</label>
                                    <input readonly type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $personal->email }}" required>
                                    @if ($errors->has('email'))
                                    <ul class="parsley-errors-list filled" id="parsley-id-5">
                                        <li class="parsley-required">{{ $errors->first('name') }}.</li>
                                    </ul>
                                    @endif
                            </div>
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Clas</label>
                                    <select class="form-control clas_select" multiple="multiple" name="clas_id[]" required>
                                        @foreach ($clas as $item)
                                            <option value="{{$item->id}}">{{$item->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Lesson</label>
                                    <select class="form-control select2" multiple="multiple" name="lesson_id[]" required>
                                        @foreach ($lesson as $item)
                                            <option value="{{$item->id}}">{{$item->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <a class="btn btn-secondary text-white" href="{{ url('business/clas_personal/index/teacher?approve=1') }}"><i class="fas fa-angle-left"></i> Back</a>
                            <button class="btn text-white bg-purple" type="submit"><i class="fas fa-check"></i> Save</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endsection
    @section('footer')
    <script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>
    <script>
            $('.select2').select2({
                    placeholder: 'Choose Lesson',
                    searchInputPlaceholder: 'Search options'
            });
            $('.clas_select').select2({
                    placeholder: 'Choose Class',
                    searchInputPlaceholder: 'Search options'
            });
        </script>
    @endsection
@show