@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Edit Service </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.servis.index')}}">Service</a></li>
                <li class="breadcrumb-item active"><a href=""></a>Edit Service</li>
            </ol>
        </div>
    </div>
</div>
<!-- end row -->

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg">
            <div class="card m-b-20">
                <div class="card-body">
                    <h4 class="mt-0"><i class=""></i>
                        <strong>#invoice{{ $service->invocie_number }}</strong></h4>
                    <hr>
                    @if (session("status"))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Good Job!</h4>
                        {{session('status')}}
                    </div>
                    @endif
                    <form action="{{route('admin.servis.update', $service->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mt-4">
                            <div class="col-4">
                                <label for="Username">Mekanik</label>
                                <select name="name_mekanik" id="mekanik"
                                    class="form-control select2 @error('name_mekanik') is-invalid @enderror">
                                    <option value="">Select Mekanik</option>
                                    @foreach ($mekaniks as $mekanik)
                                    <option value="{{$mekanik->id}}"
                                        {{$service->mekanik_id == $mekanik->id ? "selected" : ""}}>{{$mekanik->name}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('name_mekanik') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                        </div>

                        <hr>
                        @php
                        $tanggal_servis = date('m/d/Y', strtotime($service->tanggal_servis));
                        @endphp
                        <div class="row mt-5">
                            <div class="col">
                                <label for="">Date:</label>
                                <input type="text" id="datepicker" name="tanggal_servis"
                                    class="form-control @error('tanggal_servis') is-invalid @enderror"
                                    placeholder="Tanggal Transaksi" value="{{$tanggal_servis}}">
                                @error('tanggal_servis') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="Email">Customer Name</label>
                                <input type="text" name="name_customer"
                                    class="form-control @error('name_customer') is-invalid @enderror"
                                    placeholder="Customer Name" value="{{$service->customer_servis}}">
                                @error('name_customer') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                            <div class="col">
                                <label for="NoTelphone">No Polis</label>
                                <input type="text" name="no_polis"
                                    class="form-control @error('no_polis') is-invalid @enderror" placeholder="No Polis"
                                    value="{{$service->no_polis}}">
                                @error('no_polis') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="Email">Alamat</label>
                                <textarea name="alamat" id="" cols="30" rows="5"
                                    class="ckeditor form-control @error('alamat') is-invalid @enderror">{{$service->alamat}}</textarea>
                                @error('alamat')
                                <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="col">
                                <label>No Telphone</label>
                                <input type="text" name="no_telphone"
                                    class="form-control @error('no_telphone') is-invalid @enderror"
                                    placeholder="No Telphone" value="{{$service->no_telphone}}" />
                                @error('no_telphone')
                                <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="">Motor</label>
                                <select id="motor" class="form-control select2 @error('motor') is-invalid @enderror"
                                    name="motor">
                                    <option value="">Select Motor</option>
                                    @foreach ($motors as $motor)
                                    <option value="{{$motor->id}}"
                                        {{$service->motor_id == $motor->id ? "selected" : ""}}>{{$motor->name}} ||
                                        {{$motor->tipe_motor}}</option>
                                    @endforeach
                                </select>
                                @error('motor') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                            <div class="col">
                                <label for="">KM/ Datang</label>
                                <input type="text" name="km_datang"
                                    class="form-control @error('km_datang') is-invalid @enderror"
                                    placeholder="Km Datang" value="{{$service->dtlservice[0]->km_datang}}">
                                @error('motor') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="keluhan">Keluhan</label>
                                <textarea name="keluhan" id="" cols="10" rows="5"
                                    class="ckkeluhan form-control @error('keluhan') is-invalid @enderror">{{ $service->dtlservice[0]->keluhan}}</textarea>
                                @error('keluhan') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                            <div class="col">
                                <div class="col mt-3">
                                    <label for="">Tipe Servis</label>
                                    <select id="tipe_service"
                                        class="form-control select2 @error('tipe_servis') is-invalid @enderror"
                                        name="tipe_servis">
                                        <option {{$service->dtlservice[0]->tipe_servis == "BERAT" ? "selected" : ""}}
                                            value="BERAT">BERAT</option>
                                        <option {{$service->dtlservice[0]->tipe_servis == "RINGAN" ? "selected" : ""}}
                                            value="RINGAN">RINGAN</option>
                                    </select>
                                    @error('tipe_servis') <div class="help-block" style="color: red;">
                                        <strong>{{ $message }}</strong></div> @enderror
                                </div>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Waktu Pengerjaan</label>
                                <input type="text" class="form-control @error('waktu_servis') is-invalid @enderror"
                                    name="waktu_servis" value="{{$service->dtlservice[0]->waktu_servis}}">
                                @error('waktu_servis') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                            <div class="col">
                                <label for="">Harga Jasa</label>
                                <input type="text" class="form-control @error('harga_jasa') is-invalid @enderror"
                                    name="harga_jasa" value="{{$service->dtlservice[0]->harga_jasa}}"
                                    placeholder="Harga Jasa">
                                @error('harga_jasa') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                            <div class="col">
                                <label class="control-label">Status</label>
                                <select class="form-control select2 @error('status') is-invalid @enderror"
                                    name="status">
                                    <option {{$service->status == "CHECKING" ? "selected" : ""}} value="CHECKING">
                                        CHECKING</option>
                                    <option {{$service->status == "SERVICE" ? "selected" : ""}} value="SERVICE">SERVICE
                                    </option>
                                    <option {{$service->status == "FINISH" ? "selected" : ""}} value="FINISH">FINISH
                                    </option>
                                </select>
                                @error('harga_jasa') <div class="help-block" style="color: red;">
                                    <strong>{{ $message }}</strong></div> @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="row" id="barang">
                            <div class="col mt-4">
                                <a id="add_form" href="#" class="btn btn-flat btn-danger"><i
                                        class="fa fa-plus mr-2"></i> Add Barang</a>
                            </div>
                        </div>

                        <div id="appendBarang">
                            @foreach ($service->dtlservice as $value)
                            <div class="row mt-4">
                                <div class="col">
                                    <label for="">Name Barang</label>
                                    <select class="form-control select2 @error('name_barang') is-invalid @enderror"
                                        name="barang[]" id="barang[]">
                                        @foreach ($barangs as $barang)
                                        <option value="{{$barang->id}}"
                                            {{$barang->id == $value->barang_id ? "selected" : ""}}>
                                            {{$barang->name_barang}}</option>
                                        @endforeach
                                    </select>
                                    @error('name_barang')
                                    <div class="help-block" style="color: red;">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="">Jumlah</label>
                                    <input type="text" name="qty[]" id="qty_b"
                                        class="form-control flex @error('quantity') is-invalid @enderror"
                                        placeholder="Jumlah" value="{{$service->dtlservice[0]->qty}}">
                                    @error('quantity')
                                    <div class="help-block" style="color: red;">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Update
                                </button>
                                <a href="{{route('admin.servis.index')}}"
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
            <select class="form-control select2 " name="barang[]" id="barang">
                @foreach ($barangs as $barang)
                    <option value="{{$barang->id}}">{{$barang->name_barang}}</option>
                @endforeach
            </select>
                <div class="invalid-feedback">
                    {{$errors->first("")}}
                </div>
            </div>
        <div class="col">
            <input type="text" name="qty[]" id="qty_b" class="form-control @error('quantity') is-invalid @enderror" placeholder="Jumlah">
            @error('quantity')
            <div class="help-block" style="color: red;">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
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
        $("#datepicker").datepicker();

        $('#timepicker').timepicker({
            autoclose: true,
            setTime: new Date()
        })
        $('#timepicker').timepicker('setTime', new Date());

    });
</script>

{{-- <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('.ckeditor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    ClassicEditor
        .create(document.querySelector('.ckkeluhan'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script> --}}

@endsection
