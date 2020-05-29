@extends('layouts.admin')
@section('title')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Users</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Agroxa</a></li>
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active">Data Table</li>
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
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <button id="create_user" name="create_user" class="btn btn-danger waves-effect waves-light"
                        style="float: right" data-toggle="modal" data-target=".bs-example-modal-lg"><i
                            class="fa fa-plus"></i> Add User</button>
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

            {{-- form create modal --}}
            <div class="row">
                <div id="FormModal" class="modal fade bs-example-modal-lg" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myLargeModalLabel">Add User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <span id="form_resutl"></span>
                                <form id="user_form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label for="Username">Username</label>
                                            <input type="text" name="username" id="username" class="form-control"
                                                placeholder="Username">
                                        </div>
                                        <div class="col">
                                            <label for="Name">Full Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label for="Email">Email Address</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="Email Address">
                                        </div>
                                        <div class="col">
                                            <label for="NoTelphone">No Telphone</label>
                                            <input type="number" name="no_telphone" id="no_telphone"
                                                class="form-control" placeholder="No Telphone">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label for="Password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Password">
                                        </div>
                                        <div class="col">
                                            <label for="">Gender</label>
                                            <br>
                                            <div class="form-check d-inline mr-3">
                                                <input class="form-check-input mr-5" type="radio" name="gender"
                                                    id="laki-laki" value="LAKI-LAKI">
                                                <label class="form-check-label">
                                                    LAKI-LAKI
                                                </label>
                                            </div>
                                            <div class="form-check d-inline">
                                                <input class="form-check-input mr-5" type="radio" name="gender"
                                                    id="perempuan" value="PEREMPUAN">
                                                <label class="form-check-label">
                                                    PEREMPUAN
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label for="NoTelphone">Confrime Password</label>
                                            <input type="password" name="confrime_password" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label class="control-label">Role</label>
                                            <select class="form-control  select2">
                                                <option>Administator</option>
                                                <option>Top level managemen</option>
                                                <option>Operator</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <label>Address</label>
                                            <div>
                                                <textarea name="address" id="address" class="form-control"
                                                    rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label>About</label>
                                            <div>
                                                <textarea class="form-control" name="about" id="about"
                                                    rows="5"></textarea>
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
                                    <div class="form-group mt-2">
                                        <div>
                                            <input type="hidden" name="action" id="action" value="Created" />
                                            <input type="submit" name="action_button" id="action_button"
                                                class="btn btn-success waves-effect waves-light" value="Created" />
                                            <button type="reset"
                                                class="btn btn-warning waves-effect waves-light btn-flat">Reset</button>
                                            <button type="button" class="btn btn-secondary waves-effect"
                                                data-dismiss="modal">Close</button>
                                        </div>
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
{{-- end form create modal --}}

</div>
</div>


@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2({

        });
        var table = $('#datatable').DataTable({
            aaSorting: [
                [0, "desc"]
            ],
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
                    data: 'username',
                    name: 'username'
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
                    width: '120px'
                }
            ],
            columnDefs: [{
                targets: 4,
                render: function (data, type, row) {
                    var css1 = 'badge badge-success';
                    var css2 = 'badge badge-primary'
                    if (data == 'ACTIVE') {
                        css1 = 'badge badge-success';
                    }
                    if (data == 'INACTIVE') {
                        css1 = 'badge badge-primary'
                    }
                    return '<span class="' + css1 + '">' + data + '</span>';
                }
            }]
        });

    });

</script>
@endsection
