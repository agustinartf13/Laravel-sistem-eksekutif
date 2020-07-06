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

                    @php
                        $bulan_ini = date("m");
					  	$tahun_ini = date("Y");
					  	if($bulan_ini=="12") {
					  		$bulan_depan = 1;
					  		$tahun_depan = $tahun_ini+1;
					  	} else {
					  		$bulan_depan = $bulan_ini+1;
					  		$tahun_depan = $tahun_ini;
					  	}
                    @endphp

                    {{-- <div class="row">
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
                    </div> --}}

                    <form action="" method="POST" target="" id="form_peramalan">
                    <div class="row">
                        <div class="col-6">
                            <label for="name_barang">Pilih Barang</label>
                            <div class="input-group">
                                <textarea id="name_barang" name="name_barang" class="form-control" maxlength="225" rows="3" placeholder="masukan nama barang"></textarea>
                                <button type="button" class="btn btn-secondary ml-2" style="height: 50px; widows: 50px;" data-toggle="modal" data-target="#modal_databarang" id="lihat_data_barang">Pilih Barang<i class="fas fa-search ml-2"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
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
                    <div class="form-group mt-3">
                        <button type="button" id="btn_peramalan" href="#"
                        class="btn btn-danger btn-xs d-inline mr-3">Hitung Peramalan</button>
                    </div>
                    <div class="modal fade bd-example-modal-lg" id="modal_databarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Data Barang</h5>
                              <button type="button" class="close" data-dismiss="modal" id="tb_close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <table id="" class="table table-striped display">
                                  <thead>
                                      <tr>
                                          <th>Kode Barang</th>
                                          <th>Nama Barang</th>
                                          <th>Stock</th>
                                          <th>Category</th>
                                          <th>Opsi</th>
                                      </tr>
                                  </thead>
                                  @php
                                      $no = 0
                                  @endphp
                                  @foreach ($barangs as $barang)
                                  <tbody>
                                    <tr>
                                        <td>{{ $barang->kode_barang }}</td>
                                        <td>{{ $barang->name_barang }}</td>
                                        <td>{{ $barang->details_barang->stock }}</td>
                                        <td>{{ $barang->category->name }}</td>
                                        <td class="td-opsi text-center">
                                            <input class="form-check-input position-static pilih-barang" type="checkbox" name="barang[]" id="barang{{ $no++ }}" value="{{ $barang->kode_barang }}" data-nama="{{ $barang->name_barang }}">
                                        </td>
                                    </tr>
                                  </tbody>
                                  @endforeach
                              </table>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary btn-sm" id="selesai_pilih" data-dismiss="modal">Selesai</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
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
    var barang = [];
	var name = [];
	var jml = 0;

	$("button[name='tombol_pilibarang']").click(function() {
        var kode = $(this).data("kode");
        var name = $(this).data("name");
        $("#kd_barang").val(kode);
        $("#name_barang").val(name);
    });

    $("#selesai_pilih").click(function() {
		$(':checkbox:checked').each(function(i){
	    	barang[i] = $(this).val();
	    	name[i] = $(this).data('name');
	   	});
	   	jml = barang.length;
	   	$("#name_barang").val(name);

	   	barang = [];
        name = [];
    });

     $("#tb_close").click(function() {
		$("#selesai_pilih").click();
    });

</script>

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
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months"
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
