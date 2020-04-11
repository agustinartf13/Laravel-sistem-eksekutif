@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Data Penjualan</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">{{Auth::user()->username}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.pembelian.index')}}">Penjualan</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.pembelian.create')}}">Add Pebjualan</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0"><i class="mdi mdi-cart-outline"></i> Add Penjualan</h4>
                    <hr>
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible mt-2">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <form id="add_barang" action="{{route('admin.penjualan.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-4">
                            <div class="col">
                                <label for="">Date:</label>
                                <input type="text" id="datepicker" name="tanggal_transaksi"
                                    class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                    placeholder="Tanggal Transaksi">
                                @error('tanggal_transaksi')
                                <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label for="">Customer</label>
                                <input type="text" class="form-control @error('name_pembeli') is-invalid @enderror"
                                    placeholder="Name Pembeli" name="name_pembeli" value="{{old('name_pembeli')}}">
                                @error('name_pembeli')
                                <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div id="appendBarang">
                            <div class="row" id="barang">
                                <div class="col mt-4">
                                    <a id="add_form" href="#" class="btn btn-flat btn-danger"><i
                                            class="fa fa-plus mr-2"></i> Add Barang</a>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">
                                    <select class="form-control select2 @error('barang.*') is-invalid @enderror"
                                        name="barang[]" id="barang[]">
                                        <option value="">Select Barang</option>
                                        @foreach ($barangs as $barang)
                                        <option value="{{$barang->id}}">{{$barang->name_barang}}</option>
                                        @endforeach
                                    </select>
                                    @error('barang.*')
                                    <div class="help-block" style="color: red;">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" name="qty[]" id="qty_b"
                                        class="form-control @error('qty.*') is-invalid @enderror"
                                        placeholder="Jumlah">
                                    @error('qty.*')
                                    <div class="help-block" style="color: red;">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="button" onclick="removeData(this)" id="btn_remove" href="#"
                                    class="btn btn-primary btn-xs d-inline mr-3"><i class="fa fa-times"></i></button>
                                </div>

                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Create
                                </button>
                                <a href="{{route('admin.penjualan.index')}}"
                                    class="btn btn-secondary waves-effect btn-flat">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function () {

        // form add barang
        $('#add_form').click(function (event) {
            event.preventDefault();
            var appendBarang = $('#appendBarang')
            var appendBarangDetail = `
            <div class="row mt-4" id="barang">
            <div class="col">
            <select class="form-control select2 @error('barang.*') is-invalid @enderror" name="barang[]" id="barang">
                <option value="">Select Barang</option>
                @foreach ($barangs as $barang)
                    <option value="{{$barang->id}}">{{$barang->name_barang}}</option>
                @endforeach
            </select>
            @error('barang.*')
                <div class="help-block" style="color: red;">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
            </div>
        <div class="col">
            <input type="text" name="qty[]" id="qty_b" class="form-control  @error('qty.*') is-invalid @enderror" placeholder="Jumlah">
        @error('qty.*')
            <div class="help-block" style="color: red;">
                <strong>{{ $message }}</strong>
            </div>
        @enderror
        </div>

        <div class="form-group">
            <button type="button" onclick="removeData(this)" id="btn_remove" href="#"
            class="btn btn-primary btn-xs d-inline mr-3"><i class="fa fa-times"></i></button>
        </div>

        </div>
        </div>`
            $('#appendBarang').append(appendBarangDetail)
            $('.select2').select2();

            btn_remove = $('#btn_remove')
            appendBarang.on('click', '#btn_remove', function (event) {
                event.preventDefault()
                if (event.type == 'click') {
                    $(this).parents("#barang").remove();
                }
            })
        });

        //addClass UI
        $('.select2').select2();
        $('#datepicker').datepicker({
            autoclose: true,
            setDate: new Date()
        })
        $("#datepicker").datepicker().datepicker("setDate", new Date());

    });
</script>
@endsection
