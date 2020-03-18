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
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <h4 class="mt-0"><i class="fa fa-cart-plus"></i> Edit Penjualan</h4>
                    <a href="{{route('admin.penjualan.index')}}" class="btn btn-primary btn-flat"
                        style="float: right"><i class="fas fa-reply mr-2"></i>Back</a>
                    <br>
                    <form id="add_barang" action="{{route('admin.penjualan.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-4">
                            <div class="col">
                                <label for="">Date:</label>
                                <input type="text" id="datepicker" name="tanggl_transaksi"
                                    class="form-control {{$errors->first('tanggal_transaksi') ? "is-invalid" : ""}}"
                                    placeholder="Tanggal Transaksi" value="{{old('tanggal_transaksi')}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('tanggal_transaksi')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label for="">Customer</label>
                                <input type="text" class="form-control {{$errors->first('name_pembeli') ? "is-invalid" : ""}}" placeholder="Name Pembeli"
                                name="name_pembeli">
                                <div class="invalid-feedback">
                                    {{$errors->first("name_pembeli")}}
                                </div>
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
                                    <select
                                        class="form-control select2 {{$errors->first("barang") ? "is-invalid" : ""}}"
                                        name="barang[]" id="barang[]" value="{{old("barang")}}">
                                        <option value="">Select Barang</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{$barang->id}}">{{$barang->name_barang}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{$errors->first("barang")}}
                                    </div>
                                </div>
                                <div class="col">
                                    <input type="text" name="qty[]" id="qty_b"
                                        class="form-control {{$errors->first("harga_jual") ? "is-invalid" : ""}}"
                                        placeholder="Jumlah" value="{{old("qty")}}">
                                    <div class="invalid-feedback">
                                        {{$errors->first("qty")}}
                                    </div>
                                </div>
                                <button type="button" onclick="removeData(this)" id="btn_remove" href="#"
                                    class="btn btn-primary btn-xs d-inline mr-3"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Update
                                </button>
                                <a href="{{route('admin.pembelian.index')}}"
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
            <select class="form-control select2 {{$errors->first("barang_id") ? "is-invalid" : ""}}" name="barang[]" id="barang" value="{{old("barang")}}">
                <option value="">Select Barang</option>
                @foreach ($barangs as $barang)
                    <option value="{{$barang->id}}">{{$barang->name_barang}}</option>
                @endforeach
            </select>
                <div class="invalid-feedback">
                    {{$errors->first("categories_id")}}
                </div>
            </div>
        <div class="col">
            <input type="text" name="qty[]" id="qty_b" class="form-control {{$errors->first("harga_jual") ? "is-invalid" : ""}}" placeholder="Jumlah" value="{{old("qty")}}">
            <div class="invalid-feedback">
            {{$errors->first("qty")}}
            </div>
        </div>
        <button type="button" onclick="removeData(this)" id="btn_remove" href="#" class="btn btn-primary btn-xs d-inline mr-3"><i class="fa fa-times"></i></button>
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
