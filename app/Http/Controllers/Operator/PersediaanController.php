<?php

namespace App\Http\Controllers\Operator;

use App\Barang;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;

class PersediaanController extends Controller
{
    public function index() {
        $persediaan = Barang::with('details_barang')->with('category')->get();
        return view('pages.operator.persediaan.index', [
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
         $pdf = PDF::loadView('pages.operator.export_data.barang_pdf', [
             'barangs' => $barangs, 'year_today'=> $year_today
         ]);
         return $pdf->stream('barang.pdf');
     }
}
