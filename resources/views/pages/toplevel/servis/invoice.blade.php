@extends('layouts.toplevel') @section('title') @endsection @section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4>
                Invoice
                <small>INV-{{$service->invocie_number}}</small>
            </h4>
            <ol class="breadcrumb">
                <h6>
                    <li class="breadcrumb-item">
                        Tanggal Transaksi : {{$service->tanggal_servis}}
                    </li>
                </h6>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="invoice-title">
                                <h4 class="float-right font-16">
                                    <strong>{{$tanggal_servis =date('M/d/Y', strtotime($service->tanggal_servis))}}
                                        INV #{{$service->invocie_number}}</strong>
                                </h4>
                                <h3 class="mt-0">
                                    <img src="{{ url('assets/images/Honda_Logo.svg') }}" alt="logo" height="54"
                                        class="pb-2" />Sari Indah Motor
                                    <span class="text-primary">Lukluk</span>
                                </h3>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="page-header"></h5>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <address>
                                        <strong>Sari Indah Motor Lukluk:</strong><br />
                                        Address: Jalan Raya Perang IXI<br />
                                        Phone: (+62) 082146640882<br />
                                        Email: agung21@gmail.com<br />
                                    </address>
                                </div>
                                <div class="col-6 text-right">
                                    <address class="text-justify" style="float: right">
                                        Name Customer:
                                        {{$service->customer_servis}}<br />
                                        Address: {{$service->alamat}}<br />
                                        Phone: {{$service->no_telphone}}<br />
                                        No Polis: {{$service->no_polis}}<br />
                                        Tipe Motor: {{$service->motor->name}} |
                                        {{$service->motor->tipe_motor}}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4 " style="margin-top: -110px;">
                            <div class="table table-responsive table-borderless">
                                <table class="table">
                                    @php function rupiah($angka){ $hasil_rupiah
                                    = "Rp " . number_format($angka,0,',','.');
                                    return $hasil_rupiah; } @endphp
                                    <thead>
                                        <tr>
                                            <th style="width: 130px;">
                                                <strong>Tipe Service</strong>
                                            </th>
                                            <td>
                                                {{$service->dtlservice[0]->tipe_servis}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><strong>Keluhan</strong></th>
                                            <br />
                                            <td>
                                                {{$service->dtlservice[0]->keluhan}}
                                            </td>
                                            <br />
                                        </tr>
                                        <tr>
                                            <th>
                                                <strong>Waktu Service</strong>
                                            </th>
                                            <br />
                                            <td>
                                                {{$service->dtlservice[0]->waktu_servis}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><strong>Harga Jasa</strong></th>
                                            <br />
                                            <td>
                                                {{rupiah($service->dtlservice[0]->harga_jasa)}}
                                            </td>
                                            <br />
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-16">
                                        <strong>Ganti Sparepart</strong>
                                    </h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name Barang</th>
                                                    <th>Harga Jual</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no=1; @endphp @foreach
                                                ($service->dtlservice as $value)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td>
                                                        {{$value->barang->name_barang}}
                                                    </td>
                                                    <td>
                                                        {{rupiah($value->harga_jual)}}
                                                    </td>
                                                    <td>{{$value->qty}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <address>
                                <h6>
                                    <strong>Total Transaksi</strong>&nbsp;&nbsp;{{rupiah($service->sub_total)}}
                                </h6>
                            </address>
                        </div>
                    </div>
                    <div class="d-print-none">
                        <div class="float-right">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i
                                    class="fa fa-print"></i></a>
                            <a href="#" class="btn btn-danger waves-effect waves-light">Send</a>
                            <a href="{{ route('admin.servis.index') }}"
                                class="btn btn-secondary waves-effect waves-light">back</a>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
        </div>
    </div>
</div>
