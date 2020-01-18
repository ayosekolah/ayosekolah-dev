@extends('personal.layout')
    @section('header')
        <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <title> Edit a Curriculum | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1"> Edit a Curriculum</h4>
                </div>
            </div>
            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                    <div class="card card-body">
                        <form action="{{ route('personal.curriculum.update',$curriculum->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Title</label>
                                    <input type="text" name="title" value="{{ $curriculum->title }}" class="form-control" placeholder="Enter Title" required/>
                                    @if ($errors->has('file'))
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $errors->first('file') }}.</li>
                                        </ul>
                                    @endif
                                </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput" class="d-block">Busines</label>
                                <input type="text" value="{{ $curriculum->busines->name }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                    <label for="formGroupExampleInput" class="d-block">Clas</label>
                                    <?php
                                    $selector = array();
                                    $clasSelect = (explode(",",$clasID[0]));

                                    foreach($clasSelect as $s){
                                            $selector[]=   $s;
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
                                <select class="form-control select2"  name="lesson_id" id="lesson_id">
                                        @foreach ($lesson as $item)
                                            <option 
                                            @if($item->lesson_id == $curriculum->lesson_id)
                                                selected
                                            @endif
                                            value="{{$item->lesson_id }}">{{ $item->lesson->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">    
                                <div class="row">
                                    <div class="col-md-12">
                                            <label for="formGroupExampleInput" class="d-block">Change a File</label>
                                            <input type="file" name="filenya"  class="form-control"/>
                                            <span class="text-info" >Info Format File yang di dukung :  Doc, PDF, PNG dan JPG.</span>
                                            @if ($errors->has('file'))
                                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                                <li class="parsley-required">{{ $errors->first('file') }}.</li>
                                            </ul>
                                            @endif
                                            
                                    </div>
                                </div>
                            </div>
                            
                            <a class="btn btn-secondary text-white" href="{{ route('personal.curriculum.index')}}"><i class="fas fa-angle-left"></i> Back To Curriculum</a>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
                        </form>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->   
    @endsection
    @section('footer')
        <script src="{!! asset('v1/lib/parsleyjs/parsley.min.js') !!}"></script>
        <script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>
        <script>
            $(document).ready(function(){
            $('.select2').select2({
                  searchInputPlaceholder: 'Search options'
            });
            $('.clas_select').select2({
                  searchInputPlaceholder: 'Search options'
            });

                $("#busines_id").change(function(){
                    var businesId = $(this).val();

                    $.ajax({
                        url: "{{ url('personal/teacher/quiz/class/') }}/" + businesId ,
                        type: 'get',
                        dataType: 'json',
                        success:function(response){
                            var lenclas = response.clas.length;
                            clas = response.clas;
                            $("#clas_id").empty();
                            for( var i = 0; i<lenclas; i++){
                                var id = clas[i]['clas']['id'];
                                var name = clas[i]['clas']['name']
                                $("#clas_id").append("<option value='"+id+"'>"+name+"</option>");
                            }

                            var lenLesson = response.lesson.length;
                            lesson = response.lesson;
                            $("#lesson_id").empty();
                            for( var i = 0; i<lenclas; i++){
                                var id = lesson[i]['lesson']['id'];
                                var name = lesson[i]['lesson']['name']

                                $("#lesson_id").append("<option value='"+id+"'>"+name+"</option>");

                            }

                        }
                    });
                });
        });
        </script>
    @endsection
@show