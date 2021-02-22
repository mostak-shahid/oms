@extends('layouts.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Attendance</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{route('attendance.create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Add Attendance</a>
                            </div>
                            <div class="col-md-6 mb-3">
                            </div>
                        </div>
                        
                        <table id="data-table" class="table table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Hour</th>
                            </tr>
                            </thead>
                            {{--<tbody>--}}
                            {{--@if($attendances->count())--}}
                                {{--@foreach($attendances as $attendance)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{$attendance->checkin_at}}</td>--}}
                                        {{--<td>{{$attendance->user_id}}</td>--}}
                                        {{--<td>{{$attendance->intime}}</td>--}}
                                        {{--<td>{{$attendance->outtime}}</td>--}}
                                        {{--<td>{{$attendance->workhour}}</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                            {{--</tbody>--}}
                            <tfoot>
                            <tr>
                                <th class="no_filter">#</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th class="no_filter">Hour</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    {{--{{$attendances->appends(request()->except('page'))->links()}}--}}
                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        jQuery(document).ready(function ($) {
            $('#data-table tfoot th:not(.no_filter)').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            });
            var dataTable = $('#data-table').DataTable({
                //dom: "<'row'<'col-sm-12 text-center'B>>" +
                dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 text-center'B><'col-sm-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm btn-secondary"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm btn-secondary"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm btn-secondary"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm btn-secondary"
                    },
                    {
                        extend: "print",
                        className: "btn-sm btn-secondary"
                    },
                ],
                responsive: true,
                order: [[0, "desc"]],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('attendance.index')}}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        width: 60
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'checkin_at',
                        name: 'checkin_at'
                    },
                    {
                        data: 'intime',
                        name: 'intime',
                    },
                    {
                        data: 'outtime',
                        name: 'outtime',
                    },
                    {
                        data: 'workhour',
                        name: 'workhour',
                    }
                ],

                initComplete: function () {
                    // Apply the search
                    this.api().columns().every( function () {
                        var that = this;

                        $( 'input', this.footer() ).on( 'keyup change clear', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );
                }

            });
        });
    </script>
@endsection