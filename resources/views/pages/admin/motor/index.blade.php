@extends('layouts.admin')
@section('title')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Motor</h4>
            <ol class="breadcrumb">
                <li>{{ Breadcrumbs::render('motorAdmin') }}</li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                     {{-- notifikasi form validasi --}}
                     @if ($errors->has('file'))
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $errors->first('file') }}</strong>
                     </span>
                     @endif

                     {{-- notifikasi sukses --}}
                     @if ($sukses = Session::get('sukses'))
                         <div class="alert alert-success alert-block">
                             <button type="button" class="close" data-dismiss="alert">×</button>
                             <strong>{{ $sukses }}</strong>
                         </div>
                     @endif

                     <button type="button" class="btn btn-secondary" style="float: right" data-toggle="modal" data-target="#importExcel">
                         <i class="fa fa-print mr-2"></i>Import Data
                     </button>

                     <!-- Import Excel -->
                     <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                         <div class="modal-dialog" role="document">
                             <form method="post" action="{{ route('admin.motor.importexcelmotor') }}" enctype="multipart/form-data">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                     </div>
                                     <div class="modal-body">

                                         {{ csrf_field() }}

                                         <label>Pilih file excel</label>
                                         <div class="form-group">
                                             <input type="file" class="filestyle" name="file" required="required"  data-buttonname="btn-secondary">
                                         </div>

                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                         <button type="submit" class="btn btn-primary">Import</button>
                                     </div>
                                 </div>
                             </form>
                         </div>
                     </div>

                     <a
                     href="{{ route('admin.motor.exportexcelmotor') }}"
                     class="btn btn-success btn-flat d-inline mr-1"
                     style="float: right"
                     ><i class="fa fa-print"></i> Excel</a
                     >

                     <a
                     href="{{ route('admin.motor.exportpdfmotor') }}"
                     class="btn btn-primary btn-flat d-inline mr-1"
                     style="float: right"
                     ><i class="fa fa-print"></i> Pdf</a
                     >
                     
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-cube mr-2"></i>Data Motor</h4>
                    <hr>

                    <button id="btn_addmotor" name="btn_addmotor" class="btn btn-danger waves-effect waves-light mr-2"
                        style="float: right" data-toggle="modal" data-target=".bs-example-modal-lg"><i
                            class="fa fa-plus mr-2"></i>Add Motor</button>
                    <br><br><br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap table-striped mt-5"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name Motor</th>
                                <th>Tipe Motor</th>
                                <th>Jenis Motor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th>No.</th>
                            <th>Name Motor</th>
                            <th>Tipe Motor</th>
                            <th>Jenis Motor</th>
                            <th>Action</th>
                        </tfoot>
                        <tbody>
                            {{-- Server Side --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- form create modal --}}
    <div class="row">
        <div id="formMotor" class="modal fade bs-example-modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Add Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <span id="form_resutl"></span>
                        <form id="motorForm" method="" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="name">Name Motor</label>
                                <input type="text" class="form-control" id="sname" name="name" placeholder="Name Motor">
                                <div id="valid-name" style="display:none; color: red;"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tipe Motor</label>
                                <input type="tipe_motor" class="form-control" id="stipe_motor" name="tipe_motor"
                                    placeholder="Tipe Motor">
                                <div id="valid-tipe" style="display:none; color: red;"></div>
                            </div>
                            <div class="form-group">
                                <label for="perusahaan">Perusahaan</label>
                                <select name="jenis" id="jenis_motor" class="form-control select2">
                                    <option value="">SELECT</option>
                                    <option value="AUTOMATIC">AUTOMATIC</option>
                                    <option value="MANUAL">MANUAL</option>
                                </select>
                                <div id="valid-jenis" style="display:none; color: red;"></div>
                            </div>
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="hidden" name="action" id="action" value="Created" />
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-dismiss="modal">Close</button>
                                <input type="submit" name="action_btn" id="action_btn"
                                    class="btn btn-success waves-effect waves-light" value="Created" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end form modal --}}

    @endsection
    @section('js')

    @if (Session::get('success'))
    <script>
        swal({
            title: 'Good job!',
            text: 'You clicked the button!',
            type: 'success',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10'
            });
    </script>
    @endif

    <script>
        $(document).ready(function () {
            $(".select2").select2({});

            // load data view supplier server side
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('admin.api.motor')}}"
                },
                columns: [{
                    data: 'id',
                    sortable: true,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: '20'
                },

                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'tipe_motor',
                    name: 'tipe_motor'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '115px'
                }
                ],
                columnDefs: [{
                    targets: 3,
                    render: function (data, type, row) {
                        var css1 = 'badge badge-danger ';
                        var css2 = 'badge badge-success';
                        if (data == 'AUTOMATIC') {
                            css1 = 'badge badge-success';
                            return '<h6><span class="' + css1 + '">' + data +
                                '</span></h6>';
                        }
                        if (data == 'MANUAL') {
                            css2 = 'badge badge-danger';
                            return '<h6><span class="' + css2 + '">' + data +
                                '</span></h6>';
                        }
                    }
                }]
            });

            // action modal supplier
            $('#btn_addmotor').click(function () {
                $('.modal-title').text('Add New Motor');
                $('#action_btn').val('Created');
                $('#action').val('Created');

                $('#form_result').html('');
                $('#formMotor').modal('show');
            });

            $('#motorForm').on('submit', function (event) {
                event.preventDefault();
                var action_url = '';

                if ($('#action').val() == 'Created') {
                    action_url = "{{route('admin.motor.store')}}";
                }

                if ($('#action').val() == 'Updated') {
                    action_url = "{{route('admin.motor.update', 'hidden_id->id')}}";
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: action_url,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",

                    success: function (data) {
                        if (data.errors) {

                            if (data.errors.name) {
                                $('#valid-name').text(data.errors.name[0]);
                                $('#sname').addClass('is-invalid');
                                $('#valid-name').show();
                            } else {
                                $('#sname').removeClass('is-invalid');
                                $('#valid-name').hide();
                            }

                            if (data.errors.tipe_motor) {
                                $('#valid-tipe').text(data.errors.tipe_motor[0]);
                                $('#stipe_motor').addClass('is-invalid');
                                $('#valid-tipe').show();
                            } else {
                                $('#stipe_motor').removeClass('is-invalid');
                                $('#valid-tipe').hide();
                            }

                            if (data.errors.jenis) {
                                $('#valid-jenis').text(data.errors.jenis[0]);
                                $('#sjenis').addClass('is-invalid');
                                $('#valid-jenis').show();
                            } else {
                                $('#jenis_motor').removeClass('is-invalid');
                                $('#valid-jenis').hide();
                            }
                        }

                        if ($.isEmptyObject(data.errors)) {
                            $('#motorForm')[0].reset();
                            swal({
                                title: 'Good job!',
                                text: 'You clicked the button!',
                                type: 'success',
                                showCancelButton: true,
                                confirmButtonClass: 'btn btn-success',
                                cancelButtonClass: 'btn btn-danger m-l-10'
                            });
                            $('input').removeClass('is-invalid');
                            $('#datatable').DataTable().ajax.reload();
                            $('#formMotor').modal('hide');
                        }
                    }
                });
            });

            //load id motor for update
            $(document).on('click', '#edit', function (event) {
                var motorId = $(this).data('id');
                SwalUpdate(motorId);
                event.preventDefault();
            });

            // load id motor for delete
            $(document).on('click', '#delete', function (event) {
                var motorId = $(this).data('id');
                SwalDelete(motorId);
                event.preventDefault();
            });

        });

        // update action
        function SwalUpdate(motorId) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $('#motorForm').on('submit', function (event) {
                event.preventDefault();
                var action_url = '';

                if ($('#action').val() == 'Updated') {
                    action_url = "{{route('admin.motor.update', 'id')}}";
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "/admin/motor/" + motorId + "/edit",
                    data: {
                        '_method': 'POST',
                        '_token': csrf_token
                    },
                    dataType: "json",
                    success: function (data) {
                        $('#sname').val(data.result.name);
                        $('#stipe_motor').val(data.result.tipe_motor);
                        $('#jenis_motor').val(data.result.jenis).select2();

                        $('#hidden_id').val(id);
                        $('.modal-title').text('Update Data Motor');
                        $('#action_btn').val('Updated');
                        $('#action').val('Updated');
                        $('#formMotor').modal('show');
                    }
                });

            });

        }

        // delete action
        function SwalDelete(motorId) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-info',
                cancelButtonClass: 'btn btn-primary m-l-10',
                buttonsStyling: false,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                            url: "{{ url('admin/motor') }}" + '/' + motorId,
                            type: "DELETE",
                            data: {
                                '_method': 'DELETE',
                                '_token': csrf_token
                            },
                        })
                            .done(function (response) {
                                swal(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                                readMotor();
                            })
                            .fail(function () {
                                swal('Oops...', 'Something want worng with ajax!', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

            function readMotor() {
                $('#datatable').DataTable().ajax.reload();
            }
        }

    </script>
    @endsection
