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
                                <a href="{{route('attendance.create')}}" class="btn btn-success add-button add-button-modal"><i class="fa fa-plus"></i> Add Attendance</a>
                            </div>
                            <div class="col-md-6 mb-3 text-right">
                                <div class="d-inline-block">
                                    <table>
                                        <tr>
                                            <td>                                                
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="far fa-calendar-alt"></i>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control float-right" id="reservation">
                                                        <span class="input-group-append">
                                                            <a href="{{route('attendance.index')}}" class="btn btn-info">Reset</a>
                                                        </span>
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                                <!-- /.form group -->
                                            </td>
                                        </tr>
                                    </table>
                                </div>
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
    <div class="modal fade" id="modal-add-attendance">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Attendance</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('attendance.store')}}">
                        @csrf
                        <div class="form-group">
                            <select class="form-control select2" style="width: 100%;">
                                <option value="">Select an email</option>
                                <option>mostak.shahid@gmail.com</option>
                                <option>mostak.apu@gmail.com</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="add-reservation">
                                <span class="input-group-append">
                                    <a href="{{route('attendance.index')}}" class="btn btn-info">Reset</a>
                                </span>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
@section('style')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
    
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js')}}"></script>
    <script src="{{ asset('adminlte/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
    
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        let dateRange = '';
        jQuery(document).ready(function ($) {
            $('.add-button-modal').on('click', function(e){
                e.preventDefault();
                $("#modal-add-attendance").modal('show');
            });
            $('.select2').select2({
                theme: 'bootstrap4',
            });
            //Date range picker
            $('#add-reservation').daterangepicker({
                //autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' to ',
                    cancelLabel: 'Clear'
                }
            });
            $('#reservation').daterangepicker({
                //autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' to ',
                    cancelLabel: 'Clear'
                }
            }, 
            function() {
                dateRange = $(".drp-selected").text();
                console.log(dateRange);
                
                if(dateRange != '') {
                    $('#data-table').DataTable().destroy();
                    createDataTable(dateRange);
                }
                else {
                    alert('Both Date is required');
                }
                
            }); 
            
            $('#data-table tfoot th:not(.no_filter)').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            });
            createDataTable();
            function createDataTable(dateRange = ''){
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
                        data: {date:dateRange}
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
        
                
            }
        });
    </script>
@endsection