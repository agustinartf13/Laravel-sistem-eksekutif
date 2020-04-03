<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Penjualan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanPenjualanController extends Controller
{
    public function laporanJual()
    {
        return view('pages.admin.laporan.index');
    }

      // api supplier get data
      public function apipenjualan()
      {
          $penjualan = Penjualan::all();
          return DataTables::of($penjualan)
              ->addColumn('action', function ($penjualan) {
                  return '' .
                      '<a href="' . route('admin.penjualan.edit', ['penjualan' => $penjualan->id]) . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                      '&nbsp;<a href="' . route('admin.penjualan.invoice', ['id' => $penjualan->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i> Invoice</a> ' .
                      '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="' . $penjualan->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i> Delete</button>';
              })->rawColumns(['action'])->make(true);
      }
}
