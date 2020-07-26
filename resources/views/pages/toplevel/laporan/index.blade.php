@extends('layouts.toplevel')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Laporan Penjualan</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('toplevel.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Penjualan</li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-file-document-box mr-2"></i>Laporan Penjualan</h4>
                    <hr>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <h6>DATA TAHUN {{$year_today}}</h6>
                            </div>
                        </div>

                        @php
                        function rupiah($angka) {
                            $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
                            return $hasil_rupiah;
                        }

                        function TanggalIndonesia($date) {
                        $date = date('Y-m-d',strtotime($date));
                        if($date == '0000-00-00')
                            return 'Tanggal Kosong';

                        $tgl = substr($date, 8, 2);
                        $bln = substr($date, 5, 2);
                        $thn = substr($date, 0, 4);

                        switch ($bln) {
                            case 1 : {
                                    $bln = 'Januari';
                                }break;
                            case 2 : {
                                    $bln = 'Februari';
                                }break;
                            case 3 : {
                                    $bln = 'Maret';
                                }break;
                            case 4 : {
                                    $bln = 'April';
                                }break;
                            case 5 : {
                                    $bln = 'Mei';
                                }break;
                            case 6 : {
                                    $bln = "Juni";
                                }break;
                            case 7 : {
                                    $bln = 'Juli';
                                }break;
                            case 8 : {
                                    $bln = 'Agustus';
                                }break;
                            case 9 : {
                                    $bln = 'September';
                                }break;
                            case 10 : {
                                    $bln = 'Oktober';
                                }break;
                            case 11 : {
                                    $bln = 'November';
                                }break;
                            case 12 : {
                                    $bln = 'Desember';
                                }break;
                            default: {
                                    $bln = 'UnKnown';
                                }break;
                        }

                        $hari = date('N', strtotime($date));
                        switch ($hari) {
                            case 0 : {
                                    $hari = 'Minggu';
                                }break;
                            case 1 : {
                                    $hari = 'Senin';
                                }break;
                            case 2 : {
                                    $hari = 'Selasa';
                                }break;
                            case 3 : {
                                    $hari = 'Rabu';
                                }break;
                            case 4 : {
                                    $hari = 'Kamis';
                                }break;
                            case 5 : {
                                    $hari = "Jum'at";
                                }break;
                            case 6 : {
                                    $hari = 'Sabtu';
                                }break;
                            default: {
                                    $hari = 'UnKnown';
                                }break;
                        }

                        $tanggalIndonesia = "Hari ".$hari.", Tanggal ".$tgl . " " . $bln . " " . $thn;
                        return $tanggalIndonesia;
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">Pilih Tahun</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="datepicker" name="year" class="form-control" value="{{Request::get('year')}}"/>
                                        <button id="data-year" type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                <div class="col">
                                    <label for=""></label>
                                    <div class="input-group mt-2">
                                        <button type="button" class="btn btn-outline-primary" style="height: 38px;" data-toggle="modal" data-target="#exampleModal">
                                            Sale Last Week
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sale Minggu lalu</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <table id="data-sale-perweek" class="table table-borderless dt-responsive nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Transaksi</th>
                                                <th>Name Barang</th>
                                                <th>Quantitiy</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $no = 1
                                        @endphp
                                        @foreach ($saleperweeks as $item)
                                            <tbody>
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>{{TanggalIndonesia($item->tanggal_transaksi)}}</td>
                                                    <td>{{$item->name_barang}}</td>
                                                    <td>{{$item->jumlah}}</td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>

                            <hr>

                            <h4 class="mt-4 text-center " id="dt_tahun">Statistic Penjualan {{$year_today}}</h4>
                            <ul class="list-inline widget-chart m-t-20 m-b-15 text-center mt-4">
                                <li class="list-inline-item">
                                    <h5 class="mb-0" id="total_omset"> {{rupiah($total_omset)}}</h5>
                                    <p class="text-muted">Omset</p>
                                </li>
                                <li class="list-inline-item">
                                    <h5 class="mb-0" id="total_profit">{{rupiah($total_profit)}}</h5>
                                    <p class="text-muted">Profit</p>
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
                            href="{{ route('toplevel.laporan.exportexcelpenjualan') }}"
                            class="btn btn-success btn-flat d-inline"
                            style="float: right"
                            ><i class="fa fa-print"></i> Excel</a
                            >
                            <a
                            href="{{ route('toplevel.laporan.exportpdfpenjualan') }}"
                            class="btn btn-primary btn-flat d-inline mr-1"
                            style="float: right"
                            ><i class="fa fa-print"></i> Pdf</a
                            >
                            <h4>List Penjualan</h4>
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
                                        <th>Tanggal Transaksi</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice Number</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Customer</th>
                                        <th>Total</th>
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
        url: "{{route('toplevel.laporan.salepermonthjual')}}",
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
                            label: "Penjualan " + {{ $year_today }},
                            backgroundColor: "#28bbe3",
                            borderColor: "#28bbe3",
                            borderWidth: 1,
                            hoverBackgroundColor: "#28bbe3",
                            hoverBorderColor: "#28bbe3",
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
        todayBtn: 'likend',
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $("#data-year").on("click", function () {
        const data2 = $("#datepicker").val()
        // window.alert(data);

        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            });

            let ajax_get = $.ajax({
                url: "{{route('toplevel.laporan.salepermonthjual')}}",
                data: {
                    year: data2,
                    type: "GET"
                },
                success: function(data){
                    let sale = [];
                    let month = [];

                    for (var i in data[0]) {
                        sale.push(data[0][i].total_sale)
                        month.push(convertMonth(data[0][i].month));
                    }

                    actChart.data.labels=month;
                    actChart.data.datasets[0].data =sale;

                    actChart.update();

                    $('#total_omset').text(formatter.format(data.total_omset));
                    $('#total_profit').text(formatter.format(data.total_profit));
                    $('#dt_tahun').text(` Statistic Penjualan ${data2}`);
                    console.log(data);
                }
            });
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
                    url: "{{route('toplevel.api.jual')}}",
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
                ],
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
                                url: "{{ url('toplevel/penjualan') }}" + '/' + penjualanId,
                                type: "DELETE",
                                data: {
                                    '_method': 'DELETE',
                                    '_token': csrf_token
                                },
                            })
                            .done(function (response) {
                                swal('Deleted!', response.message, response.status);
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
