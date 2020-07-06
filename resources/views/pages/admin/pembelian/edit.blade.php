@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Update Pembelian</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pembelian.index') }}">Pembelian</a></li>
                <li class="breadcrumb-item active"><a href=""></a>Edit Pembelian</li>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="fa fa-cart-arrow-down mr-2"></i>Edit Pembelian <small>#Invoice{{ $pembelians->invoice_number }}</small></h4>
                    <hr>
                    <form id="add_barang" action="{{route('admin.pembelian.update', $pembelians->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @php
                        $tanggal_transaksi = date('m/d/Y', strtotime($pembelians->tanggl_transaksi));
                        @endphp
                        <div class="row mt-4">
                            <div class="col">
                                <label for="">Name Supplier</label>
                                <select class="form-control select2 {{$errors->first("supplier") ? "is-invalid" : ""}}"
                                    name="supplier" value="{{old("supplier")}}">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{$supplier->id}}"
                                        {{$pembelians->supplier_id == $supplier->id ? "selected" : ""}}>
                                        {{$supplier->name_supplier}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{$errors->first("supplier")}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <label for="">Date:</label>
                                <input type="text" id="datepicker" name="tanggl_transaksi"
                                    class="form-control {{$errors->first('tanggal_transaksi') ? "is-invalid" : ""}}"
                                    placeholder="Tanggal Transaksi" value="{{$tanggal_transaksi}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('tanggal_transaksi')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 mb-3">
                            <div class="col">
                                <label for="Status">Status</label>
                                <select class="form-control select2" name="status" id="Status" style="width: 100%;">
                                    <option {{$pembelians->status == "PROCESS" ? "selected" : ""}} value="PROCESS">
                                        PROCESS</option>
                                    <option {{$pembelians->status == "FINISH" ? "selected" : ""}} value="FINISH">FINISH
                                    </option>
                                    <option {{$pembelians->status == "CENCEL" ? "selected" : ""}} value="CANCEL">CANCEL
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row" id="barang">
                            <div class="col mt-4">
                                <a id="add_form" href="#" class="btn btn-flat btn-danger"><i
                                        class="fa fa-plus mr-2"></i> Add Barang</a>
                            </div>
                        </div>

                        <div id="appendBarang">
                            @foreach ($pembelians->dtlpembelian as $value)
                            <div class="row mt-4">
                                <div class="col">
                                    <label for="">Select Category</label>
                                    <select
                                        class="form-control select2 {{$errors->first("categories") ? "is-invalid" : ""}}"
                                        name="categories[]" id="categories" value="{{old("categories")}}">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}"
                                            {{$category->id == $value->categories_id ? "selected" : ""}}>
                                            {{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{$errors->first("categories")}}
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="">Select Barang</label>
                                    <select
                                        class="form-control select2 {{$errors->first("barang") ? "is-invalid" : ""}}"
                                        name="barang[]" id="barang[]" value="{{old("barang")}}">
                                        @foreach ($barangs as $barang)
                                        <option value="{{$barang->id}}"
                                            {{$barang->id == $value->barang_id ? "selected" : ""}}>
                                            {{$barang->name_barang}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{$errors->first("barang")}}
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="">Qty</label>
                                    <input type="text" name="qty[]" id="qty_b"
                                        class="form-control {{$errors->first("harga_jual") ? "is-invalid" : ""}}"
                                        placeholder="Jumlah" value="{{$value->qty}}">
                                    <div class="invalid-feedback">
                                        {{$errors->first("qty")}}
                                    </div>
                                </div>
                                {{-- <button type="button" onclick="removeData(this)" id="btn_remove" href="#"
                                    class="btn btn-primary btn-xs d-inline mr-3"><i class="fa fa-times"></i>
                                </button> --}}
                            </div>

                            @endforeach
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

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}")
        @endif

        // form add barang
        $('#add_form').click(function (event) {
            event.preventDefault();
            var appendBarang = $('#appendBarang')
            var appendBarangDetail = `
            <div class="row mt-4" id="barang">
            <div class="col">
                <select class="form-control select2 {{$errors->first("categories") ? "is-invalid" : ""}}" name="categories[]" id="categories" value="{{old("categories")}}">
                    <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
                </select>
                <div class="invalid-feedback">
                {{$errors->first("categories")}}
                </div>
            </div>
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
        })
    });
</script>
@endsection
