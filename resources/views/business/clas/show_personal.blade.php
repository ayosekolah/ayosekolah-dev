@extends('business.layout')
    @section('header')
        <link href="{!! asset('v1/lib/datatables.net-dt/css/jquery.dataTables.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('v1/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') !!}" rel="stylesheet">
        <link rel="stylesheet" href="{!! asset('v1/assets/css/dashforge.demo.css') !!}">
        <link href="{!! asset('v1/lib/select2/css/select2.min.css') !!}" rel="stylesheet">
        <title>All Personal In Clas | Ayo Sekolah</title>
    @endsection
    @section('contents')
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                <h4 class="mg-b-0 tx-spacing--1">All Personal In Clas</h4>
                </div>
                <div class="d-none d-md-block">
                        <a class="btn btn-sm  btn-info btn-uppercase mg-l-5 text-white" href="{{ route('business.clas.index') }}">
                            <i class="fa fa-angle-left"></i> Back To Clas
                        </a>
                </div>
            </div>
            <div class="row row-xs">
                <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <table id="data" class="table">
                        <thead>
                            <tr>
                                <th class="wd-10p">Name</th>
                                <th class="wd-20p">Type</th>
                                <th class="wd-20p">Bergabung</th>
                                <th class="wd-5p">Action</th>
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
                ajax: "{{ Request::url() }}",
                columns: [
                            { data: 'personal_busines.personal.name', name: 'personal_busines.personal.name' },
                            { data: 'personal_busines.type', name: 'personal_busines.type' },
                            { data: 'created_at', name: 'created_at' },
                            { data: 'action', name: 'action' }
                    ]
        });
        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
    </script>
    @endsection
@show