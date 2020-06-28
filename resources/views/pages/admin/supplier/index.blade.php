@extends('layouts.admin')
@section('title')

@endsection
@section('css')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Supplier</h4>
            <ol class="breadcrumb">
                {{ Breadcrumbs::render('supplierAdmin') }}
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0"><i class="mdi mdi-account-card-details mr-2"></i> Data Supplier</h4>
                    <hr>
                    @if(session('status'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <button id="btn_addsupplier" name="btn_addsupplier" class="btn btn-danger waves-effect waves-light"
                        style="float: right" data-toggle="modal" data-target=".bs-example-modal-lg"><i
                            class="fa fa-plus mr-2"></i>Add Supplier</button>
                    <br><br><br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap hover table-striped ho mt-5"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Perusahaan</th>
                                <th>No. Telphone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Perusahaan</th>
                            <th>No. Telphone</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tfoot>
                        <tbody>
                            {{-- data servs side --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- form create modal --}}
    <div class="row">
        <div id="formSupplier" class="modal fade bs-example-modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Add Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <span id="form_resutl"></span>
                        <form id="supplierForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="sname_supplier" name="name_supplier"
                                    placeholder="Full Name">
                                <div id="valid-name" style="display:none; color: red;"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="semail" name="email"
                                    placeholder="Enter email">
                                <div id="valid-email" style="display:none; color: red;"></div>
                            </div>
                            <div class="form-group">
                                <label for="perusahaan">Perusahaan</label>
                                <input type="text" class="form-control" id="sperusahaan" name="perusahaan"
                                    placeholder="Perusahaan">
                                <div id="valid-perusahaan" style="display:none; color: red;"></div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="number" class="form-control" id="sphone" name="no_telphone"
                                    placeholder="Phone Number">
                                <div id="valid-phone" style="display:none; color: red;"></div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="saddress" name="address" class="form-control" rows="4"></textarea>
                                <div id="valid-address" style="display:none; color: red;"></div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $(".select2").select2({});

            // load data view supplier server side
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('admin.api.supplier')}}"
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
                        data: 'name_supplier',
                        name: 'name_supplier'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'no_telphone',
                        name: 'no_telphone'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                    targets: 5,
                    render: function (data, type, row) {
                        var css1 = 'badge badge-success';
                        var css2 = 'badge badge-primary';
                        if (data == 'ACTIVE') {
                            css1 = 'badge badge-success';
                            return '<span class="' + css1 + '">' + data + '</span>';
                        }
                        if (data == 'INACTIVE') {
                            css2 = 'badge badge-primary';
                            return '<span class="' + css2 + '">' + data + '</span>';
                        }
                    }
                }]
            });

            // action modal supplier
            $('#btn_addsupplier').click(function () {
                $('.modal-title').text('Add New Supplier');
                $('#action_btn').val('Created');
                $('#action').val('Created');

                $('#form_result').html('');
                $('#formSupplier').modal('show');
            });

            $('#supplierForm').on('submit', function (event) {
                event.preventDefault();
                var action_url = '';

                if ($('#action').val() == 'Created') {
                    action_url = "{{route('admin.supplier.store')}}";
                }

                if ($('#action').val() == 'Updated') {
                    action_url = "{{route('admin.supplier.update', 'hidden_id->id')}}";
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

                            if (data.errors.name_supplier) {
                                $('#valid-name').text(data.errors.name_supplier[0]);
                                $('#sname_supplier').addClass('is-invalid');
                                $('#valid-name').show();
                            } else {
                                $('#sname_supplier').removeClass('is-invalid');
                                $('#valid-name').hide();
                            }

                            if (data.errors.email) {
                                $('#valid-email').text(data.errors.email[0]);
                                $('#semail').addClass('is-invalid');
                                $('#valid-email').show();
                            } else {
                                $('#semail').removeClass('is-invalid');
                                $('#valid-email').hide();
                            }

                            if (data.errors.perusahaan) {
                                $('#valid-perusahaan').text(data.errors.perusahaan[0]);
                                $('#sperusahaan').addClass('is-invalid');
                                $('#valid-perusahaan').show();
                            } else {
                                $('#sperusahaan').removeClass('is-invalid');
                                $('#valid-perusahaan').hide();
                            }

                            if (data.errors.no_telphone) {
                                $('#valid-phone').text(data.errors.no_telphone[0]);
                                $('#sphone').addClass('is-invalid');
                                $('#valid-phone').show();
                            } else {
                                $('#sphone').removeClass('is-invalid');
                                $('#valid-phone').hide();
                            }

                            if (data.errors.address) {
                                $('#valid-address').text(data.errors.address[0]);
                                $('#saddress').addClass('is-invalid');
                                $('#valid-address').show();
                            } else {
                                $('#saddress').removeClass('is-invalid');
                                $('#valid-address').hide();
                            }
                        }

                        if ($.isEmptyObject(data.errors)) {
                            $('#supplierForm')[0].reset();
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
                            $('#formSupplier').modal('hide');
                        }
                    }
                });
            });

            // edit mekanik
            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');

                $('#action_btn').val('Updated');
                $('#action').val('Updated');
                $('#form_result').html('');

                $.ajax({
                    url: "/admin/mekanik/" + id + "/edit",
                    dataType: "json",
                    success: function (data) {
                        $('#sname').val(data.result.name);
                        $('#semail').val(data.result.email);
                        $('#saddress').val(data.result.address);
                        $('#sphone').val(data.result.no_telphone);

                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Data Mekanik');
                        $('#action_button').val('Updated');
                        $('#action').val('Updated');
                        $('#formMekanik').modal('show');
                    }
                });
            });

            // load id mekani
            $(document).on('click', '#delete', function (event) {
                var supplierId = $(this).data('id');
                SwalDelete(supplierId);
                event.preventDefault();
            });

        });


        // delete action
        function SwalDelete(supplierId) {
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
                                url: "{{ url('admin/supplier') }}" + '/' + supplierId,
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
                                readSupplier();
                            })
                            .fail(function () {
                                swal('Oops...', 'Something want worng with ajax!', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

            function readSupplier() {
                $('#datatable').DataTable().ajax.reload();
            }
        }
    </script>

<script>
    jQuery(document).ready(function($){
        $('#mymodal').on('show.bs.modal', function(e){
            var button = $(e.relatedTarget);
            var modal = $(this);

            modal.find('.modal-body').load(button.data("remote"));
            modal.find('.modal-title').html(button.data("title"));
        });
    });
</script>

<div class="row">
    <div id="mymodal" class="modal fade bs-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
</div>


    @endsection
