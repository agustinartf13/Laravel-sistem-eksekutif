
@extends('layouts.toplevel')
@section('title')

@endsection


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Laporan Service</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Wellcome to Laporan Service</a></li>
                <li class="breadcrumb-item"><a href="{{route('toplevel.dashboard')}}">Dashboard</a></li>
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
                        </div>


                        @php
                        function rupiah($angka){
                            $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
                            return $hasil_rupiah;
                        }
                        @endphp
                            <div class="col-lg-4">
                                <div class="form-group">
                                    @foreach ($rank_barang as $rbrg)
                                        <label for=""><h6>Peringkat Barang</h6></label>
                                        <p style="margin-top: -10px;">Name Barang: <u>{{$rbrg->name_barang}}</u></p>
                                        <p  style="margin-top: -18px;"> total terjual sebanyak: <u>{{$rbrg->jumlah}}</u></p>
                                    @endforeach
                                </div>
                            </div>
                           <div class="col-lg-2">
                            <div class="form-group">
                                <label for=""><h6>Omset</h6></label>
                                {{rupiah($total_omset)}}
                            </div>
                           </div>
                           <div class="col-lg-2">
                            <div class="form-group" >
                                <label for=""><h6>Profit</h6></label>
                                {{rupiah($total_profit)}}
                            </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="">Pilih Tahun</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="datepicker" name="year" class="form-control" value="{{Request::get('year')}}"/>
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>



        <div class="row">
            <div class="col-xl">
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

                        <canvas id="bar" height="80"></canvas>

                    </div>
                </div>
            </div> <!-- end col -->

            {{-- <div class="col-xl">
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Penjualan Spareart Motor {{ $year_today }} </h4>

                        <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                            <li class="list-inline-item">
                                <h5 class="mb-0">{{ $status['service'] }}</h5>
                                <p class="text-muted">Service</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0">{{ $status['checking'] }}</h5>
                                <p class="text-muted">Checking</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0">{{ $status['finish'] }}</h5>
                                <p class="text-muted">Finish</p>
                            </li>
                        </ul>

                        <canvas id="flotPie1" height="215"></canvas>

                    </div>
                </div>
            </div> <!-- end col --> --}}
        </div> <!-- end row -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('toplevel.servis.create')}}" class="btn btn-danger btn-flat d-inline"
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
                                <th>Action</th>
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
                                <th>Action</th>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script>
    var ctx = document.getElementById('bar').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [
                {
                    label: "Total Omset",
                    backgroundColor: "#f5b225",
                    borderColor: "#f5b225",
                    borderWidth: 1,
                    hoverBackgroundColor: "#f5b225",
                    hoverBorderColor: "#f5b225",
                    data: {!!json_encode($omset)!!}
                },
                {
                    label: "Sales Jasa",
                    backgroundColor: "#f16c69",
                    borderColor: "#f16c69",
                    borderWidth: 1,
                    hoverBackgroundColor: "#f16c69",
                    hoverBorderColor: "#f16c69",
                    data: {!!json_encode($jasa)!!}
                },
                {
                    label: "Sales Profit",
                    backgroundColor: "#28bbe3",
                    borderColor: "#28bbe3",
                    borderWidth: 1,
                    hoverBackgroundColor: "#28bbe3",
                    hoverBorderColor: "#28bbe3",
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

<script type="text/javascript">
    $(document).ready(function () {

        $('.input-daterange').datepicker({
            todayBtn:'linked',
            format:'yyyy-mm-dd',
            autoclose:true
        });

        load_data();
        function load_data(from_date = '', to_date = '') {

            var table = $('#datatable-buttons').DataTable({
            aaSorting: [
                [0, "DESC"]
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('toplevel.api.service')}}",
                data: {from_date:from_date, to_date:to_date}
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
        }

        $('#filter').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date !='') {
                $('#datatable-buttons').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                alert('Both Data is Required');
            }
        });

        $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#datatable-buttons').DataTable().destroy();
            load_data();
        });


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
                            url: "{{ url('toplevel/servis') }}" + '/' + serviceId,
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
