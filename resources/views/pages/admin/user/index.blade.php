@extends('layouts.admin')
@section('title')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data User</h4>
            <ol class="breadcrumb">
                <li>{{ Breadcrumbs::render('user') }}</li>
            </ol>
        </div>
    </div>
</div>
<!-- end row -->

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0"><i class="mdi mdi-account-card-details mr-2"></i> Data User</h4>
                    <hr>
                    @if(session('status'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <button id="btn_addmekanik" name="btn_addmekanik" class="btn btn-danger waves-effect waves-light"
                        style="float: right" data-toggle="modal" data-target=".bs-example-modal-lg"><i
                            class="fa fa-plus mr-2"></i>Add User</button>
                    <br><br><br>
                    <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap  mt-5"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>No. Telphone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No. Telphone</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tfoot>
                        <tbody>
                            {{-- servied Side --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- form modal --}}
    <div class="row">
        <div id="formMekanik" class="modal fade bs-example-modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <span id="form_resutl"></span>
                        <form id="mekanikForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mt-4">
                                <div class="col">
                                    <label for="Username">Username</label>
                                    <input type="text" name="username" id="susername" class="form-control"
                                        placeholder="Username">
                                    <div id="valid-username" style="display:none; color: red;"></div>
                                </div>
                                <div class="col">
                                    <label for="Name">Full Name</label>
                                    <input type="text" name="name" id="sname" class="form-control"
                                        placeholder="Full Name">
                                    <div id="valid-name" style="display:none; color: red;"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="Email">Email Address</label>
                                    <input type="email" name="email" id="semail" class="form-control"
                                        placeholder="Email Address">
                                    <div id="valid-email" style="display:none; color: red;"></div>
                                </div>
                                <div class="col">
                                    <label for="NoTelphone">No Telphone</label>
                                    <input type="text" name="no_telphone" id="sno_telphone" class="form-control"
                                        placeholder="No Telphone">
                                    <div id="valid-no_telphone" style="display:none; color: red;"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="control-label">Role</label>
                                    <select class="form-control  select2" id="sroles" name="roles">
                                        <option>Administator</option>
                                        <option>Top level managemen</option>
                                        <option>Operator</option>
                                    </select>
                                    <div id="valid-roles" style="display:none; color: red;"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="Password">Password</label>
                                    <input type="password" name="password" id="spassword" class="form-control"
                                        placeholder="Password">
                                    <div id="valid-password" style="display:none; color: red;"></div>
                                </div>
                                <div class="col">
                                    <label for="NoTelphone">Confrime Password</label>
                                    <input type="password" name="confrime_password" class="form-control"
                                        id="sconfrime_password" placeholder="Confrime Password">
                                    <div id="valid-confrime_password" style="display:none; color: red;"></div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label>Address</label>
                                    <div>
                                        <textarea name="address" id="saddress" class="form-control" rows="5"></textarea>
                                        <div id="valid-address" style="display:none; color: red;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Input Image</label>
                                        <input type="file" name="image" id="filestyle" class="filestyle"
                                            data-buttonname="btn-secondary">
                                        <span class="text-muted">Kosongkan jika tidak mengubah Image</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="control-label">Status</label>
                                    <select class="form-control select2" name="status">
                                        <option>ACTIVE</option>
                                        <option>INACTIVE</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="hidden" name="action" id="action" value="Created" />
                            <div class="form-group mt-2">
                                <div>
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
</div>
</div>
</div>
{{-- end form modal --}}


@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2();
        $(".filestyle").filestyle();
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('admin.api.user')}}"
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
                data: 'email',
                name: 'email'
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
                targets: 4,
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

        // action created mekanik
        $('#btn_addmekanik').click(function () {
            $('.modal-title').text('Add New User');
            $('#action_btn').val('Created');
            $('#action').val('Created');

            $('#form_result').html('');
            $('#formMekanik').modal('show');
        });

        $('#mekanikForm').on('submit', function (event) {
            event.preventDefault();
            var action_url = '';

            if ($('#action').val() == 'Created') {
                action_url = "{{route('admin.user.store')}}";
            }

            if ($('#action').val() == 'Updated') {
                action_url = "{{route('admin.user.update', 'hidden_id->id')}}";
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

                        if (data.errors.username) {
                            $('#valid-username').text(data.errors.username[0]);
                            $('#susername').addClass('is-invalid');
                            $('#valid-username').show();
                        } else {
                            $('#susername').removeClass('is-invalid');
                            $('#valid-username').hide();
                        }

                        if (data.errors.email) {
                            $('#valid-email').text(data.errors.email[0]);
                            $('#semail').addClass('is-invalid');
                            $('#valid-email').show();
                        } else {
                            $('#semail').removeClass('is-invalid');
                            $('#valid-email').hide();
                        }

                        if (data.errors.no_telphone) {
                            $('#valid-no_telphone').text(data.errors.no_telphone[0]);
                            $('#sno_telphone').addClass('is-invalid');
                            $('#valid-no_telphone').show();
                        } else {
                            $('#sno_telphone').removeClass('is-invalid');
                            $('#valid-no_telphone').hide();
                        }

                        if (data.errors.roles) {
                            $('#valid-roles').text(data.errors.roles[0]);
                            $('#sroles').addClass('is-invalid');
                            $('#valid-roles').show();
                        } else {
                            $('#sroles').removeClass('is-invalid');
                            $('#valid-roles').hide();
                        }

                        if (data.errors.password) {
                            $('#valid-password').text(data.errors.password[0]);
                            $('#spassword').addClass('is-invalid');
                            $('#valid-password').show();
                        } else {
                            $('#spassword').removeClass('is-invalid');
                            $('#valid-password').hide();
                        }

                        if (data.errors.confrime_password) {
                            $('#valid-confrime_password').text(data.errors.confrime_password[0]);
                            $('#sconfrime_password').addClass('is-invalid');
                            $('#valid-confrime_password').show();
                        } else {
                            $('#sconfrime_password').removeClass('is-invalid');
                            $('#valid-confrime_password').hide();
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
                        $('#mekanikForm')[0].reset();
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
                        $('#formMekanik').modal('hide');
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

        // load data mekanik
        $(document).on('click', '#delete', function (event) {
            var usersId = $(this).data('id');
            SwalDelete(usersId);
            event.preventDefault();
        });

    });

    // delete action
    function SwalDelete(usersId) {
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
                        url: "{{ url('admin/user') }}" + '/' + usersId,
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
                            readMekanik();
                        })
                        .fail(function () {
                            swal('Oops...', 'Something want worng with ajax!', 'error');
                        });
                });
            },
            allowOutsideClick: false
        });

        function readMekanik() {
            $('#datatable').DataTable().ajax.reload();
        }
    }

</script>

<script>
    jQuery(document).ready(function ($) {
        $('#mymodal').on('show.bs.modal', function (e) {
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
