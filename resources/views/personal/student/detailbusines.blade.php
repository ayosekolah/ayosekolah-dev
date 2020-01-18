@extends('personal.layout')
    @section('header')
    <title> Business Clas for Student | Ayo Sekolah</title>
    <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
    <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
            <h4 class="mg-b-0 tx-spacing--1" id="x">Business Clas for Student </h4>
            </div>
            <div class="d-none d-md-block">
                <a href="{{ url('business/clas_personal/is_delete/'.$busines->id) }}?from=client&pID={{Auth::guard('personal')->user()->id }}" title="Canceld Or Delete" class="btn btn-xs btn-danger">
                    Leave a Group Business <i class="fa fa-trash tx-default"></i> 
                </a>
            </div>
        </div>
        <div class="row row-xs">
            <div class="col-md-12">
                        @include('_partial.alert')
            </div>
            <div class="col-sm-7 col-lg-7 text-center mb-4">
    
                    <div class="card card-body shadow-sm text-left">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Quiz your Clas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Quiz in Class</a>
                            </li>
                            </ul>
                            <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <table id="data_quiz" class="table" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th class="wd-20p">Play</th>
                                                    </tr>
                                                    </thead>
                                            </table>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <table id="list_clas" class="table" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                    </tr>
                                                    </thead>
                                            </table>
                                    </div>
                            </div>
                    </div>
                </div><!-- col -->
            <div class="col-sm-5 col-lg-5 mb-4">
                <div class="card card-body  shadow-sm">
                        <table id="list_curriculum" class="table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Curriculum Title</th>
                                    <th>Lesson</th>
                                </tr>
                                </thead>
                        </table>
                </div>
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- container -->   
    <?php 
    if($clasID == ''){
        $c = $clas[0]->clas->id;
    }else{
        $c = $clasID;
    }
    ?>
    @endsection
    @section('footer')
    <script src="{!! asset('v1/lib/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-dt/js/dataTables.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-responsive/js/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>
        <script>
            $('#data_quiz').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('personal/busines/quiz/student/'.$busines->busines_id.'/'.$c) }}",
                    columns: [
                                { data: 'title', name: 'title' },
                                { data: 'play', name: 'play' },
                            ]
            });

            $('#list_curriculum').DataTable({
                    lengthChange: false,
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('personal.dashboard.student.curriculum',$busines->busines_id) }}",
                    columns: [
                                { data: 'title', name: 'title' },
                                { data: 'lesson.name', name: 'lesson.name' },
                            ]
            });


            $('#list_clas').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('personal/busines/quiz/student/clas/all/'.$busines->id) }}",
                    columns: [
                                { data: 'name', name: 'name' },
                            ]
            });

            $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
            
        </script>
    @endsection
@show