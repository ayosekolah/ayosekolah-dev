@extends('business.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <title>Edit personal | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0 ">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1">Edit and Approve</h4>
                </div>
            </div>
            <div class="row row-xs bg-white">
                <div class="col-sm-12 col-lg-12 p-4">
                        <form action="{{ url('business/clas_personal/is_aprroved/'.$personal->id)  }}?redirect_url={{$redirect}}" method="POST" data-parsley-validate>
                            @csrf
                            <input type="hidden" name="type" value="teacher">
                            <input type="hidden" name="personal_busines_id" value="{{ $personal->personalBusines[0]->id }}">
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
                                    @if ($errors->has('name'))
                                    <ul class="parsley-errors-list filled" id="parsley-id-5">
                                        <li class="parsley-required">{{ $errors->first('name') }}.</li>
                                    </ul>
                                    @endif
                            </div>
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Clas</label>
                                    <?php
                                    $selector = array();
                                    foreach($personal->personalBusines[0]->ClasPersonal as $s){
                                        $selector[]=  $s->clas_id;
                                    }
                                    ?>
                                    <select class="form-control clas_select" multiple="multiple" name="clas_id[]" required>
                                        <?php $i = 0;
                                        foreach($clas as $cat){
                                            if(in_array($cat->id,$selector)) $str_flag = "selected";
                                            else $str_flag=""; ?>
                                        <option value="<?php echo $cat->id;?>" <?php echo $str_flag; ?>><?php echo ucfirst($cat->name);?></option>
                                            <?php $i++;
                                        } ?>
                                    </select>
                            </div>
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Lesson</label>
                                    <?php
                                    $selector = array();
                                    foreach($personal->personalBusines[0]->lessonPersonal as $s){
                                        $selector[]=  $s->lesson_id;
                                    }
                                    ?>
                                    <select class="form-control select2" multiple="multiple" name="lesson_id[]" required>
                                        <?php $i = 0;
                                        foreach($lesson as $cat){
                                            if(in_array($cat->id,$selector)) $str_flag = "selected";
                                            else $str_flag=""; ?>
                                        <option value="<?php echo $cat->id;?>" <?php echo $str_flag; ?>><?php echo ucfirst($cat->name);?></option>
                                            <?php $i++;
                                        } ?>
                                    </select>
                            </div>
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Is Approve   </label>
                                    <div class="custom-control custom-switch">
                                            <input type="checkbox" value="1" class="custom-control-input" id="customSwitch3" name="is_approve" {{ $personal->personalBusines[0]->is_approve == 1 ? 'checked' :'' }}>
                                            <label class="custom-control-label" for="customSwitch3">{{ $personal->personalBusines[0]->is_aprroved == 1 ? 'Approved' :'Not Approve' }}</label>
                                    </div>
                            </div>
                            <a href="#" class="btn btn-secondary text-white"onclick="window.history.go(-1); return false;"><i class="fas fa-angle-left"></i> Back</a>
                            <button class="btn text-white bg-purple" type="submit"><i class="fas fa-check"></i> Save</button>
                        </form>
                </div>
            </div>
    </div>
    @endsection
    @section('footer')
    <script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>
    <script>
            $('.select2').select2();
            $('.clas_select').select2();
        </script>
    @endsection
@show