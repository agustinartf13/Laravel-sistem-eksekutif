@extends('layouts.admin')
@section('title')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Penjualan</h4>
            <ol class="breadcrumb">
                <li>{{ Breadcrumbs::render('penjualanAdmin') }}</li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0" style="font-size: 22px"><i class="fa fa-cart-arrow-down mr-2"></i> Data
                        Penjualan</h4>
                    <hr>
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <a href="{{route('admin.laporan.jual')}}" class="btn btn-secondary btn-flat d-inline"
                        style="float: right"><i class="fa fa-print"></i></a>
                    <a href="{{route('admin.penjualan.create')}}" class="btn btn-danger btn-flat d-inline mr-2"
                        style="float: right"><i class="fa fa-plus mr-2"></i>Add Penjualan</a>
                    <br><br><br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap table-striped mt-5"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice Number</th>
                                <th>Tanggal Transaksi</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th>No</th>
                            <th>Invoice Number</th>
                            <th>Tanggal Transaksi</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th class="text-center">Action</th>
                        </tfoot>
                        <tbody>
                            {{-- server Side --}}
                        </tbody>
                        </form>
                    </table>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    @endsection

    @section('js')
    <script text="text/javascript">
        $(document).ready(function () {
            $('#datatable').DataTable({
                aaSorting: [
                    [0, "DESC"]
                ],
                processing: true,
                serverSide: true,
                ajax: "{{route('admin.api.penjualan')}}",
                columns: [{
                        data: 'id',
                        sortable: true,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        width: '20'
                    },
                    {
                        data: 'invoice_number',
                        name: 'invoice_number'
                    },
                    {
                        data: 'tanggal_transaksi',
                        name: 'tanggal_transaksi'
                    },
                    {
                        data: 'name_pembeli',
                        name: 'name_pembeli'
                    },
                    {
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp '),
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '120px'
                    }
                ]
            });

             // load id motor for delete
             $(document).on('click', '#delete', function (event) {
                var penjualanId = $(this).data('id');
                SwalDelete(penjualanId);
                event.preventDefault();
            });

        });

         // delete action
         function SwalDelete(penjualanId) {
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
                                url: "{{ url('admin/penjualan') }}" + '/' + penjualanId,
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

