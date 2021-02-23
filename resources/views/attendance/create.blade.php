@extends('layouts.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Attendance</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('attendance.index')}}">Attendance</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                        <form id="attendance-store" action="{{route('attendance.store')}}">

                                @csrf
                                <div class="form-group">
                                    <label for="user_id">Email:</label>
                                    <select id="user_id" name="user_id" class="form-control select2" style="width: 100%;" requird>
                                        <option value="">Select an email</option>
                                        @if($users->count())
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->email}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <!-- /.form-group -->
                                <div class="form-group">
                                    <label for="checkin_at">Date:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="checkin_at" name="checkin_at" required>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                                <div class="form-group">
                                    <label for="intime">In Time:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input type="text" class="form-control float-right inout-reservation" id="intime" name="intime">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                                <div class="form-group">
                                    <label for="outtime">Out Time:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input type="text" class="form-control float-right inout-reservation" id="outtime" name="outtime" value="">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                                <button type="submit" class="btn btn-primary">Add Attendance</button>



                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('style')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section('script')
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js')}}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script><!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script>
        let dateRange = '';
        jQuery(document).ready(function ($) {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
            //Date range picker
            $('#checkin_at').daterangepicker({
                //autoUpdateInput: false,
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: ' to ',
                    cancelLabel: 'Clear'
                }
            });
            $('.inout-reservation').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: true,
                locale: {
                    format: 'YYYY-MM-DD hh:mm:ss',
                    separator: ' to ',
                    cancelLabel: 'Clear'
                }
            });

            $('input.inout-reservation').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD hh:mm:ss'));
            });

            $('input.inout-reservation').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
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
            $('#attendance-store').validate({
                rules: {
                    user_id: {
                        required: true,
                    },
                    checkin_at: {
                        required: true,
                    },
                    intime: {
                        required: true
                    },
                },
                messages: {
                    user_id: {
                        required: "Please select an email address"
                    },
                    checkin_at: {
                        required: "Date is required.",
                    },
                    intime: "In Time is required"
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection