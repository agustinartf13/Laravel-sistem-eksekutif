@extends('layouts.toplevel')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Laporan Pembelian</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('toplevel.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Pembelian</li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-file-document-box mr-2"></i>Laporan Pembelian</h4>
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

                            <div class="col-lg-6">
                                <div class="form-group">
                                    @foreach ($rank_supplier as $rsupplier)
                                        <label for=""><h6>Peringkat Supplier</h6></label>
                                        <p style="margin-top: -10px;">Name Supplier: <u>{{$rsupplier->name_supplier}}</u></p>
                                        <p  style="margin-top: -18px;"> total Pembelian sebanyak: <u>{{$rsupplier->jumlah}}</u></p>
                                    @endforeach
                                </div>
                            </div>
                           <div class="col-lg-2">
                            <div class="form-group">
                                <label for=""><h6>Pengeluaran &nbsp;</h6></label>
                               <div style="margin-top: -10px;">
                                {{ rupiah($total_pengeluaran) }}
                               </div>
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

                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Pilih Tahun</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="datepicker" name="year" class="form-control" value="{{Request::get('year')}}"/>
                                        <button id="data-year" type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <h4 class="mt-4 text-center" id="dt_tahun">Statistic Pembelian {{ $year_today }} </h4>

                            <ul class="list-inline widget-chart m-t-20 m-b-15 text-center mt-4">
                                <li class="list-inline-item">
                                    <h5 class="mb-0"> </h5>
                                </li>
                                <li class="list-inline-item">
                                    <h5 class="mb-0" id="total_pengeluaran">{{rupiah($total_pengeluaran)}}</h5>
                                    <p class="text-muted">Pengeluaran</p>
                                </li>
                                <li class="list-inline-item">
                                    <h5 class="mb-0"></h5>

                                </li>
                            </ul>
                            <canvas id="myChart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a
                        href="{{ route('toplevel.laporan.exportexcelpembelian') }}"
                        class="btn btn-success btn-flat d-inline mr-3"
                        style="float: right"
                        ><i class="fa fa-print"></i> Excel</a
                        >
                        <a
                        href="{{ route('toplevel.laporan.exportpdfpembelian') }}"
                        class="btn btn-primary btn-flat d-inline mr-1"
                        style="float: right"
                        ><i class="fa fa-print"></i> Pdf</a
                        >
                    <h4>List Pembelian</h4>
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

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script type="text/javascript">
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let actChart = '';

    function convertMonth(month) {
    switch (month) {
        case 1:
            return "Januari"
            break;
        case 2:
            return "Februari"
            break;
        case 3:
            return "Maret"
            break;
        case 4:
            return "April"
            break;
        case 5:
            return "Mei"
            break;
        case 6:
            return "Juni"
            break;
        case 7:
            return "Juli"
            break;
        case 8:
            return "Agustus"
            break;
        case 9:
            return "September"
            break;
        case 10:
            return "Oktober"
            break;
        case 11:
            return "November"
            break;
        case 12:
            return "Desember"
            break;
        default:
            break;
    }
}



    loadChart("2020")

function loadChart(year) {
$.ajax({
    url: "{{route('toplevel.laporan.salepermonthbeli')}}",
    data: {
        year: year
    },
    method: "GET",
    success: function (data) {
        let sale = [];
        let month = [];


        for (var i in data[0]) {
            sale.push(data[0][i].total_sale)
            month.push(convertMonth(data[0][i].month))
        }

        console.log(data)

        var ctx = document.getElementById('myChart').getContext('2d');
        actChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: month,
                datasets: [
                    {
                        label: "Pembelian " + {{ $year_today }},
                        backgroundColor: "#f16c69",
                        borderColor: "#f16c69",
                        borderWidth: 1,
                        hoverBackgroundColor: "#f16c69",
                        hoverBorderColor: "#f16c69",
                        data: sale
                    }

                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (value, index, values) {
                                // Convert the number to a string and splite the string every 3 charaters from the end
                                value = value.toString();
                                value = value.split(/(?=(?:...)*$)/);

                                // Convert the array to a string and format the output
                                value = value.join('.');
                                return 'Rp. ' + value;
                            }
                        }
                    }]
                },
            }
        });
    },
    error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log(status);
        console.log(error);
    }
})
}

    $('.input-daterange').datepicker({
        todayBtn: 'linked',
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $("#data-year").on("click", function() {
        const data2 = $("#datepicker").val();

        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            });

        let ajax_get = $.ajax({
            url: "{{route('toplevel.laporan.salepermonthbeli')}}",
                data: {
                    year: data2
                },
                method: "GET",
                success: function (data) {
                    let sale = [];
                    let month = [];

                    for (var i in data[0]) {
                        sale.push(data[0][i].total_sale)
                        month.push(convertMonth(data[0][i].month))
                    }

                    actChart.data.labels=month;
                    actChart.data.datasets[0].data =sale;

                    actChart.update();

                    $('#total_pengeluaran').text(formatter.format(data.total_pengeluaran));
                    $('#dt_tahun').text(`Statistic Pembelian Sparepart ${data2}`);
                    console.log(data);
                }
        });

    })

    load_data();
    function load_data(from_date = '', to_date = '') {
        var table = $('#datatable-buttons').DataTable({
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
                        name: 'invoice_number'
                    },
                    {
                        data: 'tanggl_transaksi',
                        name: 'tanggl_transaksi'

                    },
                    {
                        data: 'supplier.name_supplier',
                        name: 'supplier'
                    },
                    {
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp '),
                        data: 'total_harga',
                        name: 'total_harga'
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
                }],
        });
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
