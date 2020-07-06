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
                                <select class="select2 form-control select2-multiple" multiple="multiple" @error('barang.*') is-invalid @enderror"
                                    name="barang[]" id="barang[]">
                                    <option value="">Select Barang</option>
                                    @foreach ($barangs as $barang)
                                    <option value="{{$barang->id}}">{{$barang->name_barang}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6 input-daterange">
                            <label for="">Priode Tahun</label>
                            <input type="text" name="from_date" id="from_date" class="form-control"
                                placeholder="" />
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

        </div>
    </div>
</div>
</div>
@endsection
@section('js')


{{-- <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
</script> --}}


<script>
    function loadChart() {
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
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
                    borderWidth: 1
                }]
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
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $('.select2').select2();
        $('.input-daterange').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months"
    })

        $('#btn_hitung').on('click', function () {
            const month = $('.input-daterange').val();
            // if (month === null || month === "" || year === undefined) {
            //     window.alert('pick tanggal')
            // } else {
            const bodyChart = `<div class="card-body">
                <canvas id="myChart" height="80"></canvas>
                              </div>`;
            $('#card_chart').html("")
            $('#card_chart').append(bodyChart)
            loadChart()
            // }
        })

        $('#filter').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $('#datatable-buttons').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                alert('Both Data is Required');
            }
        });

        $('#refresh').click(function () {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#datatable-buttons').DataTable().destroy();
            load_data();
        });
    });

    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
@endsection
