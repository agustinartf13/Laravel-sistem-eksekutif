<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanBeli()
    {
        return view('pages.admin.laporan.index');
    }

    public function laporanJual()
    {
        return view('pages.admin.laporan.index2');
    }

    public function laporanService()
    {
        return view('pages.admin.laporan.index3');
    }
}