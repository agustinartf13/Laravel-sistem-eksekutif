@extends('layouts.toplevel')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Perhitunagn Peramalan</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('toplevel.dashboard')}}">Dashboard</a></li>
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
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-google-analytics mr-2"></i>
                        Perhitunagn
                        Peramalan</h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label for="">Pilih Barang</label>
                            <div class="input-group mb-3">
                                <select class="form-control select2 @error('barang.*') is-invalid @enderror"
                                name="barang[]" id="barang[]">
                                <option value="">Select Barang</option>
                                @foreach ($barangs as $barang)
                                <option value="{{$barang->id}}">{{$barang->name_barang}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col input-daterange">
                            <label for="">Priode Awal</label>
                            <input type="text" name="from_date" id="from_date" class="form-control"
                                placeholder="From Date" />
                        </div>
                        <div class="col input-daterange">
                            <label for="">Priode Akhir</label>
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" id="btn_peramalan" href="#"
                        class="btn btn-danger btn-xs d-inline mr-3">Hitung Peramalan</button>
                    </div>
                </div>
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
                    label: "Sales Analytics",
                    backgroundColor: "#28bbe3",
                    borderColor: "#28bbe3",
                    borderWidth: 1,
                    hoverBackgroundColor: "#28bbe3",
                    hoverBorderColor: "#28bbe3",

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
$(document).ready(function() {

    $('.select2').select2();
    $('.input-daterange').datepicker({
        todayBtn: 'likend',
        format: 'yyyy-mm-dd',
        autoclose: true
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
    });

        $("#datepicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });

</script>

@endsection
