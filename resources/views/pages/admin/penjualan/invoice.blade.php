@extends('layouts.admin')
@section('title')

@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4>
                Invoice
                <small>INV-{{$pembelians->invoice_number}}</small>
            </h4>
            <ol class="breadcrumb">
                <h6><li class="breadcrumb-item">Tanggal Transaksi : {{$pembelians->tanggl_transaksi}}</li></h6>
            </ol>
        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="invoice-title">
                                <h4 class="float-right font-16"><strong>{{$tanggl_transaksi =date('M/d/Y', strtotime($pembelians->tanggl_transaksi))}} INV #{{$pembelians->invoice_number}}</strong></h4>
                                <h3 class="mt-0">
                                    {{-- <img src="assets/images/Honda_Logo.svg" alt="logo" height="24"/> --}}
                                    <i class="fa fa-globe"></i> Sari Indah Motor <span class="text-primary">Lukluk</span>
                                </h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                <h5 class="page-header">
                                   Pembelian Barang
                                    <small class="pull-right">{{$tanggl_transaksi =date('M/d/Y', strtotime($pembelians->tanggl_transaksi))}}</small>
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
                                    <address>
                                        <strong>{{$pembelians->supplier->name_supplier}}</strong><br>
                                        Address: {{$pembelians->supplier->address}}<br>
                                        Company: {{$pembelians->supplier->perusahaan}}<br>
                                        Phone: {{$pembelians->supplier->no_telphone}}<br>
                                        Email: {{$pembelians->supplier->email}}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 m-t-10">
                                </div>
                                <div class="col-6 m-t-10 text-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        <small class="pull-right">{{$tanggl_transaksi =date('M/d/Y', strtotime($pembelians->tanggl_transaksi))}}</small><br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-16"><strong>Order Summery</strong></h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td><strong>No</strong></td>
                                                <td class="text-center"><strong>Barang</strong></td>
                                                <td class="text-center"><strong>Price</strong></td>
                                                <td class="text-center"><strong>Qty</strong></td>
                                                <td class="text-right"><strong>SubTotals</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                function rupiah($angka) {
                                                    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
                                                    return $hasil_rupiah;
                                                }
                                                $no = 1;
                                            @endphp
                                            @foreach ($pembelians->barangs as $value)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td class="text-center">{{$value->name_barang}}</td>
                                            </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-print-none">
                                        <div class="float-right">
                                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                            <a href="#" class="btn btn-primary waves-effect waves-light">Send</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->
                </div>
@endsection
