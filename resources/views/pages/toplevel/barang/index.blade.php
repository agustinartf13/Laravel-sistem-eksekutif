@extends('layouts.toplevel')
@section('title')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Barang</h4>
            <ol class="breadcrumb">
                <li>{{ Breadcrumbs::render('barangToplevel') }}</li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-cube mr-2"></i>Add Barang</h4>
                    <hr>
                    <button id="btn_addbarang" name="btn_addbarang" class="btn btn-danger waves-effect waves-light"
                        style="float: right" data-toggle="modal" data-target=".bs-example-modal-lg"><i
                            class="fa fa-plus mr-2"></i>Add Barang</button>
                    <br><br><br>
                    <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap  mt-5"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name Category</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga Pokok</th>
                                <th>Harga Jual</th>
                                <th>Stock</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th>No.</th>
                            <th>Name Category</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Pokok</th>
                            <th>Harga Jual</th>
                            <th>Stock</th>
                            <th class="text-center">Action</th>
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
        <div id="formBarang" class="modal fade bs-example-modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Default</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <span id="form_resutl"></span>
                        <form id="barangForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="row mt-4">
                                <div class="col">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" name="kode_barang" id="skode_barang" class="form-control"
                                        placeholder="Kode Barang">
                                    <div id="valid-kodebrg" style="display:none; color: red;"></div>
                                </div>
                                <div class="col">
                                    <label for="Name">Name Barang</label>
                                    <input type="text" name="name_barang" id="sname_barang" class="form-control"
                                        placeholder="Name Barang">
                                    <div id="valid-namebrg" style="display:none; color: red;"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="control-label">Category Name</label>
                                    <select class="form-control select2" name="categories_id" id="data-category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                        <option id="data-category" value="{{$category->id}}">{{$category->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div id="valid-category" style="display:none; color: red;"></div>
                                </div>
                                <div class="col">
                                    <label for="">Harga Pokok</label>
                                    <input type="text" name="harga_dasar" id="sharga" class="form-control"
                                        placeholder="Harga Pokok">
                                    <div id="valid-harga" style="display:none; color: red;"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label>Description</label>
                                    <div>
                                        <textarea class="form-control" id="sdescription" name="description"
                                            rows="5"></textarea>
                                        <div id="valid-descript" style="display:none; color: red;"></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="">Harga Jual</label>
                                    <input type="text" id="sharja_jual" name="harga_jual" class="form-control"
                                        placeholder="Harga Jual">
                                    <div id="valid-hrgjual" style="display:none; color: red;"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="">Stock</label>
                                    <input type="text" id="stock_b" name="stock" class="form-control"
                                        placeholder="Stock">
                                    <div id="valid-stock" style="display:none; color: red;"></div>
                                </div>
                                <div class="col">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Input Image</label>
                                        <input type="file" id="simage" name="image" class="filestyle"
                                            data-buttonname="btn-secondary">
                                    </div>
                                </div>
                                <div class="col">
                                </div>
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
                    url: "{{route('toplevel.api.barang')}}"
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
                        data: 'category.name',
                        name: 'category.name'
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'name_barang',
                        name: 'name_barang'
                    },
                    {
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp '),
                        data: 'details_barang.harga_dasar',
                        name: 'details_barang.harga_dasar'
                    },
                    {
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp '),
                        data: 'details_barang.harga_jual',
                        name: 'details_barang.harga_jual'
                    },
                    {
                        data: 'details_barang.stock',
                        name: 'details_barang.stock'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '115px'
                    }
                ],
            });

            // action modal Barang
            $('#btn_addbarang').click(function () {
                $('.modal-title').text('Add New Barang');
                $('#action_btn').val('Created');
                $('#action').val('Created');

                $('#form_result').html('');
                $('#formBarang').modal('show');
            });

            $('#barangForm').on('submit', function (event) {
                event.preventDefault();
                var action_url = '';

                if ($('#action').val() == 'Created') {
                    action_url = "{{route('toplevel.barang.store')}}";
                }

                if ($('#action').val() == 'Updated') {
                    action_url = "{{route('toplevel.barang.update', 'id')}}"
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

                            if (data.errors.kode_barang) {
                                $('#valid-kodebrg').text(data.errors.kode_barang[0]);
                                $('#skode_barang').addClass('is-invalid');
                                $('#valid-kodebrg').show();
                            } else {
                                $('#skode_barang').removeClass('is-invalid');
                                $('#valid-kodebrg').hide();
                            }

                            if (data.errors.name_barang) {
                                $('#valid-namebrg').text(data.errors.name_barang[0]);
                                $('#sname_barang').addClass('is-invalid');
                                $('#valid-namebrg').show();
                            } else {
                                $('#sname_barang').removeClass('is-invalid');
                                $('#valid-namebrg').hide();
                            }

                            if (data.errors.categories_id) {
                                $('#valid-category').text(data.errors.categories_id[0]);
                                $('#data-category').addClass('is-invalid');
                                $('#valid-category').show();
                            } else {
                                $('#data-category').removeClass('is-invalid');
                                $('#valid-category').hide();
                            }

                            if (data.errors.harga_jual) {
                                $('#valid-harga').text(data.errors.harga_jual[0]);
                                $('#sharga').addClass('is-invalid');
                                $('#valid-harga').show();
                            } else {
                                $('#sharga').removeClass('is-invalid');
                                $('#valid-harga').hide();
                            }

                            if (data.errors.harga_jual) {
                                $('#valid-hrgjual').text(data.errors.harga_jual[0]);
                                $('#sharga_jual').addClass('is-invalid');
                                $('#valid-hrgjual').show();
                            } else {
                                $('#sharga_jual').removeClass('is-invalid');
                                $('#valid-hrgjual').hide();
                            }

                            if (data.errors.description) {
                                $('#valid-descript').text(data.errors.description[0]);
                                $('#sdescription').addClass('is-invalid');
                                $('#valid-descript').show();
                            } else {
                                $('#sdescription').removeClass('is-invalid');
                                $('#valid-descript').hide();
                            }

                            if (data.errors.stock) {
                                $('#valid-stock').text(data.errors.stock[0]);
                                $('#stock_b').addClass('is-invalid');
                                $('#valid-stock').show();
                            } else {
                                $('#stock_b').removeClass('is-invalid');
                                $('#valid-stock').hide();
                            }
                        }

                        if ($.isEmptyObject(data.errors)) {
                            $('#barangForm')[0].reset();
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
                            $('#formBarang').modal('hide');
                        }
                    }
                })
            });

            // edit mekanik
            $(document).on('click', '.edit', function () {
                var id = $(this).attr('id');

                $('#action_btn').val('Updated');
                $('#action').val('Updated');
                $('#form_result').html('');

                $.ajax({
                    url: "/toplevel/mekanik/" + id + "/edit",
                    dataType: "json",
                    success: function (data) {
                        $('#sname').val(data.result.name);
                        $('#semail').val(data.result.email);
                        $('#saddress').val(data.result.address);
                        $('#sphone').val(data.result.no_telphone);

                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Data Barang');
                        $('#action_button').val('Updated');
                        $('#action').val('Updated');
                        $('#formBarang').modal('show');
                    }
                });
            });

            // load id mekani
            $(document).on('click', '#delete', function (event) {
                var barangId = $(this).data('id');
                SwalDelete(barangId);
                event.preventDefault();
            });

        });

        // delete action
        function SwalDelete(barangId) {
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
                                url: "{{ url('toplevel/barang') }}" + '/' + barangId,
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
                                readBarang();
                            })
                            .fail(function () {
                                swal('Oops...', 'Something want worng with ajax!', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

            function readBarang() {
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
