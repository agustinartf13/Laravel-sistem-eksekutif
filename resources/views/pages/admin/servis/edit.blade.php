@extends('layouts.admin')
@section('title')

@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Edit Data Service</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.servis.index')}}">Service</a></li>
                <li class="breadcrumb-item"><a href="{{route('admin.servis.create')}}"></a>Add Service</li>
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
                    <h4 class="mt-0"><i class="mdi mdi-settings mr-2"></i> Edit Service</h4>
                    <br>
                    <form action="{{route('admin.servis.update', $service->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mt-4">
                            <div class="col-4">
                                <label for="Username">Mekanik</label>
                                <select name="name_mekanik" id="mekanik" class="form-control select2">
                                    <option value="">Select Mekanik</option>
                                    @foreach ($mekaniks as $mekanik)
                                        <option value="{{$mekanik->id}}" {{$service->mekanik_id == $mekanik->id ? "selected" : ""}}>{{$mekanik->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{$errors->first('mekanik')}}
                                </div>
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
                                    class="form-control {{$errors->first('tanggal_servis') ? "is-invalid" : ""}}"
                                    placeholder="Tanggal Transaksi" value="{{$tanggal_servis}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('tanggal_servis')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="Email">Customer Name</label>
                                <input type="text" name="name_customer"
                                    class="form-control {{$errors->first('name_customer') ? "is-invalid" : ""}}"
                                    placeholder="Customer Name" value="{{$service->customer_servis}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('name_customer')}}
                                </div>
                            </div>
                            <div class="col">
                                <label for="NoTelphone">No Polis</label>
                                <input type="text" name="no_polis"
                                    class="form-control {{$errors->first('no_polis') ? "is-invalid" : ""}}"
                                    placeholder="No Polis" value="{{$service->no_polis}}">
                                <div class="invalid-feedback">
                                    {{$errors->first('no_polis')}}
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="">Motor</label>
                                <select id="motor" class="form-control select2" name="motor">
                                    <option value="">Select Motor</option>
                                    @foreach ($motors as $motor)
                                        <option value="{{$motor->id}}" {{$service->motor_id == $motor->id ? "selected" : ""}}>{{$motor->name}} || {{$motor->tipe_motor}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="keluhan">Keluhan</label>
                                <textarea name="keluhan" id="" cols="10" rows="5" class="form-control">{{$service->dtlservice[0]->keluhan}}</textarea>
                                <div class="invalid-feedback">
                                    {{$errors->first('keluhan')}}
                                </div>
                            </div>
                            <div class="flex col">
                                <div class="col">
                                    <label for="">KM/ Datang</label>
                                    <input type="text" name="km_datang"
                                        class="form-control {{$errors->first('km_datang') ? "is-invalid" : ""}}"
                                        placeholder="Km Datang" value="{{$service->dtlservice[0]->km_datang}}">
                                    <div class="invalid-feedback">
                                        {{$errors->first('km_datang')}}
                                    </div>
                                </div>

                                <div class="col mt-3">
                                <label for="">Tipe Servis</label>
                                <select id="tipe_service" class="form-control select2" name="tipe_servis">
                                    <option {{$service->dtlservice[0]->tipe_servis == "BERAT" ? "selected" : ""}} value="BERAT">BERAT</option>
                                    <option {{$service->dtlservice[0]->tipe_servis == "RINGAN" ? "selected" : ""}} value="RINGAN">RINGAN</option>
                                </select>
                            </div>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Waktu Pengerjaan</label>
                                <input type="text" class="form-control" name="waktu_servis" value="{{$service->dtlservice[0]->waktu_servis}}">
                            </div>
                            <div class="col">
                                <label for="">Harga Jasa</label>
                                <input type="text" class="form-control" name="harga_jasa" value="{{$service->dtlservice[0]->harga_jasa}}"
                                placeholder="Harga Jasa">
                            </div>
                            <div class="col">
                                <label class="control-label">Status</label>
                                <select class="form-control select2 {{$errors->first('status') ? "is-invalid" : ""}}" name="status">
                                    <option {{$service->status == "CHECKING" ? "selected" : ""}} value="CHECKING">CHECKING</option>
                                    <option {{$service->status == "SERVICE" ? "selected" : ""}} value="SERVICE">SERVICE</option>
                                    <option {{$service->status == "FINISH" ? "selected" : ""}} value="FINISH">FINISH</option>
                                </select>
                                <div class="invalid-feedback">
                                    {{$errors->first('status')}}
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div id="appendBarang">
                            @foreach ($service->dtlservice as $value)
                            <div class="row" id="barang">
                                <div class="col mt-2">
                                    <a id="add_form" href="#" class="btn btn-flat btn-danger"><i
                                    class="fa fa-plus mr-2"></i> Add Barang</a>
                                </div>
                            </div>
                            <div class="row mt-4">

                                <div class="col-8">
                                    <select
                                        class="form-control select2 {{$errors->first("name_barang[]") ? "is-invalid" : ""}}"
                                        name="barang[]" id="barang[]">
                                        <option value="">Select Barang</option>
                                        @foreach ($barangs as $barang)
                                        <option value="{{$barang->id}}" {{$barang->id == $value->barang_id ? "selected" : ""}}>{{$barang->name_barang}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{$errors->first("name_barang")}}
                                    </div>
                                </div>
                                <div class="col">
                                    <input type="text" name="qty[]" id="qty_b"
                                        class="form-control {{$errors->first("qty") ? "is-invalid" : ""}}"
                                        placeholder="Jumlah" value="{{$value->qty}}">
                                    <div class="invalid-feedback">
                                        {{$errors->first("qty")}}
                                    </div>
                                </div>
                                <button type="button" onclick="removeData(this)" id="btn_remove" href="#"
                                    class="btn btn-primary btn-xs d-inline mr-3"><i class="fa fa-times"></i></button>
                            </div>
                            @endforeach
                        </div>


                        <div class="form-group mt-3">
                            <div>
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-flat">
                                    Submit
                                </button>
                                <a href="{{route('admin.servis.index')}}" class="btn btn-secondary waves-effect btn-flat">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end col -->
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
                    <div class="col-8">
                    <select class="form-control select2 {{$errors->first("barang_id") ? "is-invalid" : ""}}" name="barang[]" id="barang" value="{{old("barang")}}">
                        <option value="">Select Barang</option>

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
                $("#datepicker").datepicker();

                $('#timepicker').timepicker({
                    autoclose: true,
                    setTime: new Date()
                })
                $('#timepicker').timepicker('setTime', new Date());

            });
        </script>
        @endsection
