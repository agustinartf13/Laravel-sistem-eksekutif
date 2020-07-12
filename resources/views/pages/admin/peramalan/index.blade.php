@extends('layouts.admin')
@section('title')

@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Perhitunagn Peramalan</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Perhitungan Peramalan</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-google-analytics mr-2"></i>Perhitunagn Peramalan</h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for="">Pilih Barang</label>
                            <div class="input-group mb-3">
                                <select class="select2 form-control" name="barang" id="forecast_barang"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Priode Tahun</label>
                            <input type="text" id="year_forecast" class="form-control" placeholder="From Date" />
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="button" id="btn_hitung" href="#"
                            class="btn btn-danger btn-xs d-inline mr-3">Hitung Peramalan</button>
                    </div>
                </div>
            </div>

            <div class="card m-b-20 mt-4">
                <div class="">
                    <div id="card_chart"></div>
                </div>
            </div>

            <div class="card m-b-20 mt-4">
                <div class="">
                    <div id="tabel-forecast"></div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
@endsection
@section('js')


<script type="text/javascript">
    $(document).ready(function () {

        function convertMonth(month) {
            switch (month) {
                case 1:
                    return "Januari";
                    break;
                case 2:
                    return "Februari";
                    break;
                case 3:
                    return "Maret";
                    break;
                case 4:
                    return "April";
                    break;
                case 5:
                    return "Mei";
                    break;
                case 6:
                    return "Juni";
                    break;
                case 7:
                    return "Juli";
                    break;
                case 8:
                    return "Agustus";
                    break;
                case 9:
                    return "September";
                    break;
                case 10:
                    return "Oktober";
                    break;
                case 11:
                    return "November";
                    break;
                case 12:
                    return "Desember";
                    break;
                default:
                    break;
            }
        }

        $('.select2').select2();

        $('#year_forecast').datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        })

        $("#forecast_barang").select2({
            placeholder: "Pilih Barang",
            allowClear: true,
            ajax: {
                url: '/admin/peramalan/load_barang',
                method: 'GET',
                dataType: 'json',
                data: function (params) {
                return {
                    searchTerm: params.term
                }
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                console.log(status);
                console.log(error);
            }
        }
        })

        $("#btn_hitung").on("click", function() {
            if ($("#forecast_barang").val() == null) {
                swal(
                    'Barang Belum di Pilih ?',
                    'silahkan pilih tahun terlebih dahulu',
                    'question'
                )
            }
            else if ($("#year_forecast").val() == "") {
                swal(
                    'Tahun Belum di Pilih ?',
                    'silahkan pilih tahun terlebih dahulu',
                    'error'
                )
            } else {
                const barang = $("#forecast_barang").val()
                const year = $("#year_forecast").val()
                const bodyChart = `<div class="card-body">
                    <canvas id="myChart" height="80"></canvas>
                    </div>`;
                    $('#card_chart').html("")
                    $('#card_chart').append(bodyChart)
                    loadChart()

                const dataForecast = `<div class="card-body"><h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-cube mr-2"></i>Hasil Peramalan</h4><table id="datatable" class="table table-bordered table-striped dt-responsive nowrap  mt-5"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Penjualan</th>
                        <th>Peramalan</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Periode</th>
                        <th>Penjualan</th>
                        <th>Peramalan</th>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
                </table>
                </div>`;
                $('#tabel-forecast').html("")
                $('#tabel-forecast').append(dataForecast)

                loadForecast(barang, year)
            }
        })

        function loadForecast(barang, year) {
            $.ajax({
                url: '/admin/peramalan/index',
                method: "GET",
                data: {
                    barang: barang,
                    year: year
                },
                success: function (data) {
                    console.log(data)
                },
                error: function () {

                }
            })
        }

        function loadChart(year) {
            $.ajax({
                url: "{{route('admin.peramalan')}}",
                data: {
                    year: year
                },
                method: "GET",
                success: function (data) {
                    let sale = [];
                    let month = [];

                    for (var i in data[0]) {
                        sale.push(data[0][i].total)
                        month.push(convertMonth(data[0][i].month))
                    }

                    console.log(data)

                    var ctx = document
                        .getElementById('myChart')
                        .getContext('2d');
                    actChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ["Januari", "February", "Maret", "April", "Mei", "Juni", "July", "Agustus", "September", "Oktober", "November", "Desember"],
                            datasets: [
                        {
                        label: "Peramalan ",
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


        // $('#btn_hitung').on('click', function () {
        //     const month = $('.input-daterange').val();
        //     if (month === null || month === "" || year === undefined) {
        //         window.alert('pick tanggal')
        //     } else {
        //     const bodyChart = `<div class="card-body">
        //         <canvas id="myChart" height="80"></canvas>
        //                       </div>`;
        //     $('#card_chart').html("")
        //     $('#card_chart').append(bodyChart)
        //     loadChart()
        //     }
        // })

    });


</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
@endsection
