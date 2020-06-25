@extends('layouts.toplevel')
@section('title')

@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Dashboard</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Welcome to {{Auth::user()->username}} Dashboard</li>
            </ol>
            @if (session("status"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                {{session('status')}}
            </div>
            @endif

            @php
            function rupiah($angka){
                $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
                return $hasil_rupiah;
            }
            @endphp

        </div>
    </div>
</div>
<!-- end row -->

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger mini-stat position-relative">
                <div class="card-body">
                    <div class="mini-stat-desc">
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Jasa Service</h6>
                            <h3 class="mb-3 mt-0">{{ rupiah($total_jasa) }}</h3>
                            <div class="">
                                <span class="badge badge-light text-danger"> +11% </span> <span class="ml-2">From previous
                                    period</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cash-multiple display-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat position-relative">
                <div class="card-body">
                    <div class="mini-stat-desc">
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Sale Sparepart</h6>
                            <h3 class="mb-3 mt-0">{{ rupiah($total_omset) }}</h3>
                            <div class="">
                                <span class="badge badge-light text-success"> -29% </span> <span class="ml-2">From
                                    previous period</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-buffer display-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat position-relative">
                <div class="card-body">
                    <div class="mini-stat-desc">
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Pengeluaran</h6>
                            <h3 class="mb-3 mt-0">{{ rupiah($total_pengeluaran) }}</h3>
                            <div class="">
                                <span class="badge badge-light text-primary"> 0% </span> <span class="ml-2">From
                                    previous period</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline display-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning mini-stat position-relative">
                <div class="card-body">
                    <div class="mini-stat-desc">
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Sparepart Sold</h6>
                            <h3 class="mb-3 mt-0">{{ $terjual_qty }}</h3>
                            <div class="">
                                <span class="badge badge-light text-info"> +89% </span> <span class="ml-2">From previous
                                    period</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-briefcase-check display-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card m-b-20">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Statistic Service Motor {{$year_today}}</h4>

                    <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                        <li class="list-inline-item">
                            <h5 class="mb-0"> {{rupiah($total_omset)}}</h5>
                            <p class="text-muted">Omset</p>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="mb-0">{{rupiah($total_jasa)}}</h5>
                            <p class="text-muted">Pendapatan Jasa</p>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="mb-0">{{rupiah($total_profit)}}</h5>
                            <p class="text-muted">Profit</p>
                        </li>
                    </ul>

                    <canvas id="line_a" height="80"></canvas>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-6">
            <div class="card m-b-20">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Pembelian Sparepart {{ $year_today }} </h4>

                    <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                        <li class="list-inline-item">
                            <h5 class="mb-0"> </h5>

                        </li>
                        <li class="list-inline-item">
                            <h5 class="mb-0">{{rupiah($total_pengeluaran)}}</h5>
                            <p class="text-muted">Pengeluaran</p>
                        </li>
                        <li class="list-inline-item">
                            <h5 class="mb-0"></h5>
                        </li>
                    </ul>
                    <canvas id="line_b" height="80"></canvas>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row">
        <div class="col-6">
            <div class="card m-b-20">
                <div class="card-body">

        <h5>List Penjualan</h5>
        <br>

        <table id="datatable" class="table table-bordered dt-responsive nowrap table-striped mt-5"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Invoice Number</th>
                <th>Tanggal Transaksi</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <th>No</th>
            <th>Customer</th>
            <th>Invoice Number</th>
            <th>Tanggal Transaksi</th>
            <th>Total</th>
            <th>Total</th>
        </tfoot>
        <tbody>
            {{-- server Side --}}
        </tbody>
        </form>
    </table>
    </div>
</div>
</div>

<div class="col-6">
    <div class="card">
        <div class="card-body">

            <h4>List Pembelian</h4>
            <br />
            <table id="datatable_a" class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Invoice Number</th>
                        <th>Tanggal pesan</th>
                        <th>Suppliers</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Invoice Number</th>
                        <th>Tanggal pesan</th>
                        <th>Suppliers</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>
<div class="row">
</div>

@endsection
@section('js')
<script>
    var ctx = document.getElementById('line_b').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [
                {
                    label: "Pengeluaran",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 2,
                    data: {!!json_encode($pengeluaran)!!}
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('line_a').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [
                {
                    label: "Omset",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 2,
                    data: {!!json_encode($omset)!!}
                },
                {
                    label: "Jasa",
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 2,
                    data: {!!json_encode($jasa)!!}
                },
                {
                    label: "Profit",
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 2,
                    data: {!!json_encode($profit)!!}
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<script text="text/javascript">
    $(document).ready(function () {

    load_data();
    function load_data(from_date = '', to_date = '') {
        $('#datatable').DataTable({
            aaSorting: [
                [0, "DESC"]
            ],
            processing: true,
            serverSide: true,
            ajax: "{{route('toplevel.show.data')}}",
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
                    name: 'invoice_number',
                    width: '80px'
                },
                {
                    data: 'tanggal_transaksi',
                    name: 'tanggal_transaksi',
                    width: '80px'
                },
                {
                    data: 'name_pembeli',
                    name: 'name_pembeli',
                    width: '80px'
                },
                {
                    data: 'total_harga',
                    name: 'total_harga',
                    width: '80px'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '80px'
                }
            ]
        });
    }

    });

</script>

<script type="text/javascript">
    $(document).ready(function() {

        load_data();
        function load_data(from_date = '', to_date = '') {
            var table = $('#datatable_a').DataTable({
            aaSorting: [
                        [0, "DESC"]
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{route('toplevel.api.beli')}}",
                        data:{from_date:from_date, to_date:to_date}
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
                            data: 'invoice_number',
                            name: 'invoice_number',
                            width: '80px'
                        },
                        {
                            data: 'tanggl_transaksi',
                            name: 'tanggl_transaksi',
                            width: '80px'

                        },
                        {
                            data: 'supplier.name_supplier',
                            name: 'supplier',
                            width: '80px'
                        },
                        {
                            data: 'total_harga',
                            name: 'total_harga',
                            width: '80px'
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
                            width: '80px'
                        }
                    ],
                    columnDefs: [{
                        targets: 5,
                        render: function (data, type, row) {
                            var css1 = 'badge badge-danger ';
                            var css2 = 'badge badge-success';
                            var css3 = 'badge badge-dark';
                            if (data == 'FINISH') {
                                css1 = 'badge badge-success';
                                return '<h6><span class="' + css1 + '">' + data +
                                '</span></h6>';
                            }
                            if (data == 'PROCESS') {
                                css2 = 'badge badge-danger';
                                return '<h6><span class="' + css2 + '">' + data +
                                '</span></h6>';
                            }
                            if (data == 'CANCEL') {
                                css3 = 'badge badge-dark';
                                return '<h6><span class="' + css3 + '">' + data +
                                '</span></h6>';
                            }
                        }
                    }]
                });
            }
        });

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
