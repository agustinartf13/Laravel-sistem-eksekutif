@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Laporan Service</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Wellcome to Laporan Service</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-file-document-box mr-2"></i>
                        Laporan
                        Service</h4>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <h6>DATA TAHUN {{$year_today}}</h6>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text btn btn-primary btn-sm" id="basic-addon1">Pilih Tahun</span>
                                </div>
                                <input type="text" id="datepicker" class="form-control" aria-label="Username"
                                    aria-describedby="basic-addon1" value="{{Request::get('year')}}">
                                <button class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </div>


                        @php
                        function rupiah($angka){
                            $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
                            return $hasil_rupiah;
                        }
                        @endphp

                        <div class="col-lg-4"></div>
                        <div class="col-lg-2"></div>
                            <div class="form-group">
                                <label for=""><h6>Omset</h6></label>
                                {{rupiah($total_omset)}}
                            </div>
                            <div class="form-group ml-3" >
                                <label for=""><h6>Profit</h6></label>
                                {{rupiah($total_profit)}}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xl-6">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Bar Chart</h4>

                        <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                            <li class="list-inline-item">
                                <h5 class="mb-0">2541</h5>
                                <p class="text-muted">Activated</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0">84845</h5>
                                <p class="text-muted">Pending</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0">12001</h5>
                                <p class="text-muted">Deactivated</p>
                            </li>
                        </ul>

                        <canvas id="bar" height="300"></canvas>

                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Pie Chart</h4>

                        <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                            <li class="list-inline-item">
                                <h5 class="mb-0">2536</h5>
                                <p class="text-muted">Activated</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0">69421</h5>
                                <p class="text-muted">Pending</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0">89854</h5>
                                <p class="text-muted">Deactivated</p>
                            </li>
                        </ul>

                        <canvas id="pie" height="260"></canvas>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('admin.servis.create')}}" class="btn btn-danger btn-flat d-inline"
                        style="float: right"><i class="fa fa-plus mr-2"></i>Add Service</a>
                    <h4>List Service</h4>
                    <hr>
                    <div class="row input-daterange mb-3">
                        <div class="col-md-4">
                            <input type="text" name="from_date" id="from_date" class="form-control"
                                placeholder="From Date" readonly />
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date"
                                readonly />
                        </div>
                        <div class="col-md-4">
                            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                            <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                        </div>
                    </div>
                    <br />

                    <!-- /.box-header -->

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice Number</th>
                                <th>Tanggal Service</th>
                                <th>No Polis</th>
                                <th>Customer Service</th>
                                <th>Tipe Motor</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Invoice Number</th>
                                <th>Tanggal Service</th>
                                <th>No Polis</th>
                                <th>Customer Service</th>
                                <th>Tipe Motor</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                    </table>


                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#datatable-buttons').DataTable({
            aaSorting: [
                [0, "DESC"]
            ],
            processing: true,
            serverSide: true,
            ajax: "{{route('admin.api.servis')}}",
            columns: [{
                    data: 'id',
                    sortable: true,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: '20'
                },
                {
                    data: 'invocie_number',
                    name: 'invocie_number'
                },
                {
                    data: 'tanggal_servis',
                    name: 'tanggal_servis'
                },
                {
                    data: 'no_polis',
                    name: 'no_polis'
                },
                {
                    data: 'customer_servis',
                    name: 'customer_servis'
                },
                {
                    data: 'motor.tipe_motor',
                    name: 'motor'
                },
                {
                    data: 'status',
                    name: 'status',
                    width: '80'
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
                targets: 6,
                render: function (data, type, row) {
                    var css1 = 'badge badge-danger ';
                    var css2 = 'badge badge-success';
                    var css3 = 'badge badge-warning';
                    if (data == 'FINISH') {
                        css1 = 'badge badge-success';
                        return '<h6><span class="' + css1 + '">' + data +
                            '</span></h6>';
                    }
                    if (data == 'SERVICE') {
                        css2 = 'badge badge-danger';
                        return '<h6><span class="' + css2 + '">' + data +
                            '</span></h6>';
                    }
                    if (data == 'CHECKING') {
                        css3 = 'badge badge-warning';
                        return '<h6><span class="' + css3 + '">' + data +
                            '</span></h6>';
                    }
                }
            }],
            dom: 'lBfrtip',
            lengthChange: true,
            buttons: ['copy', 'excel', 'pdf', 'print'],
        });

        table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

        // load id motor for delete
        $(document).on('click', '#delete', function (event) {
            var serviceId = $(this).data('id');
            SwalDelete(serviceId);
            event.preventDefault();
        });
    });

    // delete action
    function SwalDelete(serviceId) {
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
                            url: "{{ url('admin/servis') }}" + '/' + serviceId,
                            type: "DELETE",
                            data: {
                                '_method': 'DELETE',
                                '_token': csrf_token
                            },
                        })
                        .done(function (response) {
                            swal('Deleted!', response.message, response.status);
                            readLaporan();
                        })
                        .fail(function () {
                            swal('Oops...', 'Something want worng with ajax!', 'error');
                        });
                });
            },
            allowOutsideClick: false
        });

        function readLaporan() {
            $('#datatable').DataTable().ajax.reload();
        }
    }

    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

    function load_data(from_date = '', to_date = '') {
        $('#datatable-buttons').DataTable({
            
        })
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
