<?php

namespace App\Http\Controllers\Toplevel;

use App\Barang;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class PersediaanController extends Controller
{
    public function index() {
        $persediaan = Barang::with('details_barang')->with('category')->get();
        return view('pages.toplevel.persediaan.index', [
            'persediaan' => $persediaan
        ]);
    }

     // api persediaan
     public function apipersediaan()
     {
        $persediaan = Barang::with('details_barang')->with('category')->orderBy('id', 'DESC')->get();
        return DataTables::of($persediaan)
            ->addColumn('action', function ($persediaan) {
                return '';
            })->rawColumns(['action'])->make(true);
        return response()->toJson(['persediaan' => $persediaan]);
     }

    public function exportExcel()
    {
        return Excel::download(new BarangExport, 'persediaan.xlsx');
    }

    public function exportPdf()
    {
        $year_today = Carbon::now()->format('Y');
        $barangs = Barang::with('category', 'details_barang')->get();
        $pdf = PDF::loadView('pages.toplevel.export_data.barang_pdf', [
            'barangs' => $barangs, 'year_today'=> $year_today
        ]);
        return $pdf->stream('barang.pdf');
    }
}
