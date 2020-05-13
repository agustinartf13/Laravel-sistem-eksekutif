<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pembelian;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanPembelianController extends Controller
{
    // index
    public function laporanBeli()
    {
        return view('pages.admin.laporan.index2');
    }

    // api supplier get data
    public function apipembelian()
    {
        $pembelian = Pembelian::with('supplier')->with('barang')->get();
        return DataTables::of($pembelian)
            ->addColumn('action', function ($pembelian) {
                return '' .
                '&nbsp;<a href="#mymodal" data-remote="' . route('admin.pembelian.show', ['pembelian' => $pembelian->id]) . '" data-toggle="modal" data-target="#mymodal" data-title=" Invoice Number #' . $pembelian->invoice_number . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>' .
                '&nbsp;<a href="' . route('admin.pembelian.edit', ['pembelian' => $pembelian->id]) . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>' .
                '&nbsp;<a href="' . route('admin.pembelian.invoice', ['id' => $pembelian->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>' .
                '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="' . $pembelian->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>';
            })->rawColumns(['action'])->make(true);
            return response()->toJson(['pembelian' => $pembelian]);
    }


}