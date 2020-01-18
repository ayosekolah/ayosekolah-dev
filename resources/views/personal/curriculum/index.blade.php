@extends('personal.layout')
    @section('header')
        <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <title>All Curriculum {{ uCfirst(Request::segment(4)) }} | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1">All Curriculum</h4>
                </div>
                <div class="d-none d-md-block">
                        <a class="btn btn-sm  btn-primary btn-uppercase mg-l-5 text-white" href="{{ route('personal.curriculum.create') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus wd-10 mg-r-5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                            Create new a Curriculum
                        </a>
                </div>
            </div>
            <div class="row row-xs">
                <div class="col-md-12">
                        @include('_partial.alert')
                </div>
                <div class="col-sm-12 col-lg-12">
                    <div class="card card-body">
                        <table id="data" class="table">
                            <thead>
                            <tr>
                                <th class="wd-30p">Title</th>
                                <th>Business</th>
                                <th>Lesson</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('footer')
    <script src="{!! asset('v1/lib/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-dt/js/dataTables.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-responsive/js/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') !!}"></script>
    <script src="{!! asset('v1/lib/select2/js/select2.min.js') !!}"></script>

    <script>
        $('#data').DataTable({
                order: [[5, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: "{{ route('personal.curriculum.data') }}",
                columns: [
                            { data: 'title', name: 'title' },
                            { data: 'busines.name', name: 'busines.name' },
                            { data: 'lesson.name', name: 'lesson.name' },
                            { data: 'ekstensi', name: 'ekstensi' },
                            { data: 'sizes', name: 'sizes' },
                            { data: 'created_at', name: 'created_at' },
                            { data: 'action', name: 'action' }
                    ]
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    </script>
    @endsection
@show