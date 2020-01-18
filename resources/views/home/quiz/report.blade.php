@extends('personal.layout')
@section('header')
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.dashboard.css') !!}">   
    <title>Report | {{env('APP_NAME','Ayo Sekolah') }}</title>
    <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
    <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
@endsection
@section('contents')
<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
        <h4 class="mg-b-0 tx-spacing--1">Report quizzes </h4>
        </div>
    </div>
    <div class="row row-xs">
        <div class="col-md-12">
                    @include('_partial.alert')
        </div>
        <div class="col-lg-12 col-xl-10">
        <div class="media rounded shadow-sm mb-3 bd bg-white ">
                <img src="{{ getImg(Storage::url($quiz->image)) }}" class="wd-150 rounded mg-r-30" alt="">
                <div class="media-body pt-3">
                    <h5 class="mg-b-10 tx-inverse">{{ $quiz->title }}</h5>         
                    <span class="mg-b-10 tx-purple tx-bold pt-5">{{ $quiz->quizQuestion->count() }} Question</span><br>
                    By : <span class="mg-b-10 tx-info tx-bold mt-2">{{ $quiz->teacherAll->name }} </span><br>
                    <span class="badge badge-light mt-2">{{ $quiz->created_at->format('D, d/m/Y') }}</span>
                </div>
        </div>
        <br>
        </div>
        <div class="col-lg-12 col-xl-10">
                <div class="table-responsive">
                    <table id="data" class="table mg-b-0  bg-white">
                        <thead>
                        <tr>
                            <th class="wd-5p">Avatar</th>
                            <th class="wd-10p">Name</th>
                            <th class="wd-10p">True</th>
                            <th class="wd-10p">False</th>
                            <th class="wd-10p">Score</th>
                            <th class="wd-10p">Created At</th>
                        </tr>
                        </thead>
                    </table>
                </div>
        </div>
        <div class="col-lg-12 col-xl-10 ">
                <a href="{{ url('quiz/general/report/') }}" class="btn bg-purple tx-white">Back</a>
        </div>
    </div><!-- row -->
</div><!-- container -->   
@endsection
@section('footer')
    <script src="{!! asset('v1/lib/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-dt/js/dataTables.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-responsive/js/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>
    <script>
        $(document).ready(function(){
            $('#data').DataTable({
                order: [[ 1, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: "{{ url('quiz/general/report_data/'.$id ) }}",
                columns: [
                            { data: 'avatar', name: 'avatar' },
                            { data: 'student.name', name: 'student.name' },
                            { data: 'true', name: 'true' },
                            { data: 'false', name: 'false' },
                            { data: 'score', name: 'score' },
                            { data: 'created_at', name: 'created_at' },
                    ]
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
        });
    </script>
@endsection
@show