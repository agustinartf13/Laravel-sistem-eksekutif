<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanServiceController extends Controller
{
    public function laporanService()
    {
        return view('pages.admin.laporan.index3');
    }

    // api data service
    public function apiservis()
    {
        $service = Service::with('dtlservice')->with('motor')->orderBy('id', 'DESC')->get();
        return DataTables::of($service)
            ->addColumn('action', function ($service) {
                return '' .
                    '<a href="' . route('admin.servis.edit', $service->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                    '&nbsp;<a href="' . route('admin.servis.invoice', ['id' => $service->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i> Invoice</a> ' .
                    '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="' . $service->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i> Delete</button>';
            })->rawColumns(['action'])->make(true);
        return response()->toJson(['service' => $service]);
    }
}
