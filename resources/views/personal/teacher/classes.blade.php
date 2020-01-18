@extends('personal.layout')
    @section('header')
        <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <title>Classess | {{env('APP_NAME','Ayo Sekolah') }}</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1">All Classes</h4>
                </div>
            </div>
            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <table id="data" class="table">
                        <thead>
                        <tr>
                            <th class="wd-20p">Name</th>
                            <th class="wd-10p">Created At</th>
                            <th class="wd-10p">Action</th>
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
                order: [[ 2, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: "{{ route('personal.teacher.get_data.class') }}",
                columns: [
                            { data: 'clas.name', name: 'clas.name' },
                            { data: 'created_at', name: 'created_at' },
                            { data: 'action', name: 'action' },
                    ]
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    </script>
    @endsection
@show