@extends('personal.layout')
    @section('header')
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">  
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet"> 
        <title>Create a New Quiz | {{env('APP_NAME','Ayo Sekolah') }}</title>
        <style>
            .image-upload > input
            {
                display: none;
            }
            .image-upload img
            {
                width: 150px;
                cursor: pointer;
            }
            body {
                background: rgb(13,12,12);
                background: linear-gradient(90deg, rgba(13,12,12,0.85) 0%, rgba(13,12,12,0.85) 50%, rgba(13,12,12,0.85) 100%);
            }
            .navbar{
                display: none !important;
            }
        </style>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0 ">
            <div class="row row-xs ">
                <div class="col-md-6 offset-md-3 ">
                    <div class="card card-body rounded-15">
                        <form action="{{ url('personal/teacher/quiz/class/store') }}" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="d-block">Title</label>
                            <input name="title"  type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Enter Quiz Title"  required>
                            @if ($errors->has('title'))
                            <ul class="parsley-errors-list filled" id="parsley-id-5">
                                <li class="parsley-required">{{ $errors->first('title') }}.</li>
                            </ul>
                            @endif
                        </div>
                        <div class="form-group">
                                <label for="formGroupExampleInput" class="d-block">Description</label>
                                <textarea name="description" id="" cols="30" rows="1" class="form-control" placeholder="Enter Description Quiz" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="d-block">Busines</label>
                            <select class="form-control select2"  name="busines_id" id="busines_id" required>
                                    <option label="Choose Lesson"></option>
                                    @foreach ($busines as $item)
                                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="d-block">Clas</label>
                            <select class="form-control select2"  name="clas_id[]" id="clas_id" multiple required>
                                    <option label="Choose Lesson"></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput" class="d-block">Lesson</label>
                            <select class="form-control select2"  name="lesson_id" id="lesson_id" required>
                                    <option label="Choose Lesson"></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                        <label for="formGroupExampleInput" class="d-block">Image</label>
                                        <div class="image-upload">
                                                <label for="profile-img">
                                                    <img  id="profile-img-tag" src="{{ url('v1/images/defaults/placeholder.jpg') }}" width="400px" class="img-thumbnail"/>
                                                </label>
                                                <input id="profile-img" type="file" name="image" class="form-control" required/>
                                        </div>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <input type="hidden" class="form-control" name="durations" placeholder="Duration with minutes " min="60" value="120" required/>
                        </div>
                        <a class="btn btn-secondary text-white tx-20" href="{{ url('/') }}"><i class="fas fa-angle-left"></i> Back to Home</a>
                        <button class="btn bg-purple text-white tx-20" type="submit"><i class="fas fa-check"></i> Next</button>
                        </form>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
    </div><!-- container -->   
    @endsection
    @section('footer')
    <script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>
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
    $(document).ready(function(){

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