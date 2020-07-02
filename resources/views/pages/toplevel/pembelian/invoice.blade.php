@extends('layouts.toplevel')
@section('title')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4>
                Invoice
                <small>INV-{{$pembelian->invoice_number}}</small>
            </h4>
            <ol class="breadcrumb">
                <h6>
                    <li class="breadcrumb-item">Tanggal Transaksi : {{$pembelian->tanggl_transaksi}}</li>
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
                                    <strong>{{$tanggl_transaksi =date('M/d/Y', strtotime($pembelian->tanggl_transaksi))}}
                                        INV
                                        #{{$pembelian->invoice_number}}</strong></h4>
                                <h3 class="mt-0">
                                    <img src="{{ url('assets/images/Honda_Logo.svg') }}" alt="logo" height="54"
                                    class="pb-2" />
                                    Sari Indah Motor <span class="text-primary">Lukluk</span>
                                </h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="page-header">

                                    </h5>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <address>
                                        <strong>Sari Indah Motor Lukluk:</strong><br>
                                        Address: Jalan Raya Perang IXI<br>
                                        Phone: (+62) 082146640882<br>
                                        Email: agung21@gmail.com<br>
                                    </address>
                                </div>
                                <div class="col-6 text-right">
                                    <address class="text-justify" style="float: right">
                                        Name Supplier: {{$pembelian->supplier->name_supplier}}<br>
                                        Email: {{$pembelian->supplier->email}}<br>
                                        Company: {{$pembelian->supplier->perusahaan}}<br>
                                        Address: {{$pembelian->supplier->address}}<br>
                                        Phone: {{$pembelian->supplier->no_telphone}}<br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-16"><strong>Order Summery</strong></h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                @php
                                                function rupiah($angka){
                                                    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
                                                    return $hasil_rupiah;
                                                }
                                                @endphp
                                                <tr>
                                                    <th>No</th>
                                                    <th class="text-center">Name Barang</th>
                                                    <th class="text-center">Harga</th>
                                                    <th class="text-center">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=1;
                                                @endphp
                                                 @foreach ($pembelian->dtlpembelian as $value)
                                                 <tr>
                                                  <td>{{$no++}}</td>
                                                  <td class="text-center">{{$value->barang->name_barang}}</td>
                                                  <td class="text-center">{{$value->harga_beli}}</td>
                                                  <td class="text-center">{{$value->qty}}</td>
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
                                <h6> <strong>Total Transaksi</strong>&nbsp;&nbsp;{{rupiah($pembelian->total_harga)}}
                                </h6>
                            </address>
                        </div>

                    </div>
                    <div class="d-print-none">
                        <div class="float-right">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i
                                    class="fa fa-print"></i></a>
                            <a href="#" class="btn btn-danger waves-effect waves-light">Send</a>
                            <a href="{{route('admin.pembelian.index')}}"
                                class="btn btn-secondary waves-effect waves-light">back</a>
                        </div>
                    </div>
                </div>
            </div>
            @endsection
