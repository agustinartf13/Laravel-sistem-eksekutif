@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Create Pembelian</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pembelian.index') }}">Pembelian</a></li>
                <li class="breadcrumb-item active"><a href=""></a>Add Pembelian</li>
            </ol>
        </div>
    </div>
</div>
<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0 header-title" style="font-size: 22px"><i class="mdi mdi-cart-outline mr-2"></i>Add Pembelian</h4>
                    <hr>
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible mt-2">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <form id="add_barang" action="{{route('admin.pembelian.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row mt-4">

                            <div class="col">
                                <label for="">Name Supplier</label>
                                <select class="form-control select2 @error('supplier') is-invalid @enderror"
                                    name="supplier" value="{{old("supplier")}}">
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name_supplier}}</option>
                                    @endforeach
                                </select>
                                @error('supplier')
                                <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <label for="">Date:</label>
                                <input type="text" id="datepicker" name="tanggl_transaksi"
                                    class="form-control @error('tanggl_transaksi') is-invalid @enderror"
                                    placeholder="Tanggal Transaksi" value="{{old('tanggal_transaksi')}}">
                                @error('tanggl_transaksi')
                                <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <label for="Status">Status</label>
                                <select class="form-control select2 @error('status') is-invalid @enderror" name="status"
                                    id="Status" style="width: 100%;">
                                    <option value="PROCESS">PROCESS</option>
                                    <option value="FINISH" selected>FINISH</option>
                                    <option value="CANCEL">CANCEL</option>
                                </select>
                                @error('status')
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
                                    <select class="form-control select2 @error('categories.*') is-invalid @enderror"
                                        name="categories[]" id="categories">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('categories.*')
                                    <div class="help-block" style="color: red;">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

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
                                        class="form-control @error('qty.*') is-invalid @enderror" placeholder="Jumlah">
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
                <select class="form-control select2 @error('categories.*') is-invalid @enderror" name="categories[]" id="categories">
                    <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
                </select>
                @error('categories.*')
                    <div class="help-block" style="color: red;">
                        <strong>{{ $message }}</strong>
                    </div>
                 @enderror
            </div>
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
            <input type="text" name="qty[]" id="qty_b" class="form-control @error('qty.*') is-invalid @enderror" placeholder="Jumlah">
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
