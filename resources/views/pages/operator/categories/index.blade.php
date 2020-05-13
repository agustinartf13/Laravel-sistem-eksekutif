@extends('layouts.operator')
@section('title')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Categories</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{Auth::user()->username}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('operator.categories.index')}}">Categories</a></li>
                <li class="breadcrumb-item active"><a href="{{route('operator.categories.create')}}">Add Data Categories</a></li>
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
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <h4 class="mt-0"><i class="mdi mdi-cube"></i> Data Categories</h4>
                    <hr>
                    <button id="btn_addcategory" name="btn_addcategory" class="btn btn-danger waves-effect waves-light"
                        style="float: right" data-toggle="modal" data-target=".bs-example-modal-lg"><i
                            class="fa fa-plus mr-2"></i>Add Category</button>
                    <br><br><br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap table-striped mt-5"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name Categories</th>
                                <th>Categories Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th>No.</th>
                            <th>Name Categories</th>
                            <th>Categories Image</th>
                            <th>Action</th>
                        </tfoot>
                        <tbody>
                            {{-- data Server Side --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- form modal --}}
    <div class="row">
        <div id="formCategory" class="modal fade bs-example-modal-lg formCategory" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <span id="form_resutl"></span>
                        <form id="categoryForm" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="form-group mt-3">
                                <label>Name Category</label>
                                <input type="text" name="name" id="sname" class="form-control"
                                    placeholder="Name Category" />
                                <div id="valid-name" style="display:none; color: red; margin-top: 2px"></div>
                            </div>
                            <div class="form-group">
                                <label>Input Image Category</label>
                                <input type="file" id="simage" name="image" class="filestyle"
                                    data-buttonname="btn-secondary">
                                <div id="valid-image" class="invalid-feedback message"></div>
                            </div>
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="hidden" name="action" id="action" value="Created" />
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-dismiss="modal">Close</button>
                                <input type="submit" name="action_button" id="action_button"
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
            $('.filestyle').filestyle({});

            // get data categories
            var table = $('#datatable').DataTable({

                processing: true,
                serverSide: true,
                ajax: "{{ route('operator.api.categories') }}",
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
                        data: 'show_photo',
                        name: 'show_photo'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '115px'
                    }
                ]
            });

            // action modal supplier
            $('#btn_addcategory').click(function () {
                $('.modal-title').text('Add New Category');
                $('#action_btn').val('Created');
                $('#action').val('Created');

                $('#form_result').html('');
                $('#formCategory').modal('show');
            });


            $('#btn_addcategory').on('click', function () {
                $('#categoryForm')[0].reset();

            });
            // insert data category
            $('#categoryForm').on('submit', function (event) {
                event.preventDefault();
                var action_url = '';

                if ($('#action').val() == 'Created') {
                    action_url = "{{route('operator.categories.store')}}";
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
                        var html = '';
                        if (data.errors) {
                            if (data.errors.name) {
                                $('#valid-name').text(data.errors.name[0]);
                                $('#sname').addClass('is-invalid');
                                $('#valid-name').show();
                            } else {
                                $('#sname').removeClass('is-invalid');
                                $('#valid-name').hide();
                            }

                            if (data.errors.image) {
                                $('#valid-image').text(data.errors.image[0]);
                                $('#simage').addClass('is-invalid');
                                $('#valid-image').show();
                            } else {
                                $('#simage').removeClass('is-invalid');
                                $('#valid-image').hide();
                            }
                        }

                        if ($.isEmptyObject(data.errors)) {
                            $('#categoryForm')[0].reset();
                            swal({
                                title: "Data Suucessfully Created!",
                                text: data.success,
                                icon: "success",
                                button: "Close",
                            });
                            $('input').removeClass('is-invalid');
                            $('#datatable').DataTable().ajax.reload();
                            $('#formCategory').modal('hide');
                        }
                    }
                });
            });

            // load id mekani
            $(document).on('click', '#delete', function (event) {
                var categoryId = $(this).data('id');
                SwalDelete(categoryId);
                event.preventDefault();
            });

        });


        // delete action
        function SwalDelete(categoryId) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: 'it will be deleted permanently!',
                type: 'warning',
                showCancelButton: true,
                confrimButtonColor: '#3058d0',
                cancelButtonColor: '#d33',
                confrimButtonText: 'Yes, delete it!',
                showLoaderOnConfrim: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                                url: "{{ url('operator/categories') }}" + '/' + categoryId,
                                type: "DELETE",
                                data: {
                                    '_method': 'DELETE',
                                    '_token': csrf_token
                                },
                            })
                            .done(function (response) {
                                swal('Deleted!', response.message, response.status);
                                readCategory();
                            })
                            .fail(function () {
                                swal('Oops...', 'Something want worng with ajax!', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

            function readCategory() {
                $('#datatable').DataTable().ajax.reload();
            }
        }
    </script>
    @endsection
