@extends('business.layout')
    @section('header')
        <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <title>All {{ uCfirst(Request::segment(4)) }} | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1">All {{ uCfirst(Request::segment(4)) }}</h4>
                </div>
                <div class="d-none d-md-block">
                        <a class="btn btn-sm  btn-primary btn-uppercase mg-l-5 text-white" href="{{ route('business.clas_personal.index',['type' => Request::segment(4).'?approve=1']) }}">
                            Approve
                        </a>
                        <a class="btn btn-sm  btn-info btn-uppercase mg-l-5 text-white" href="{{ route('business.clas_personal.index',['type' => Request::segment(4).'?approve=0']) }}">
                            Pending
                        </a>
                </div>
            </div>
            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <table id="data" class="table">
                        <thead>
                        <tr>
                            <th class="wd-20p">Name</th>
                            <th class="wd-10p">Is Aproved</th>
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
                order: [[ 3, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: "{{ url('business/clas_personal/get_data/'. Request::segment(4)).'?approve='. $ap }}",
                columns: [
                            { data: 'name', name: 'name' },
                            { data: 'is_approved_yes', name: 'is_approved_yes' },
                            { data: 'created_at', name: 'created_at' },
                            { data: 'action', name: 'action' }
                    ]
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    </script>
    @endsection
@show