<?php

namespace App\Http\Controllers\Toplevel;

use App\Http\Controllers\Controller;
use App\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Exports\PembelianExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LaporanPembelianController extends Controller
{
    public function totalSalePerMonth(Request $request){

        if ($request->get('year') != '') {
            $year_today = $request->get('year');
        } else {
            $year_today = Carbon::now()->format('Y');
        }
        $month_today = Carbon::now()->format('m');

        // salePerMonth Penjualan Barang
        $data = DB::table('pembelians')->select(DB::raw('sum(total_harga) as `total_sale`'), DB::raw('MONTH(tanggl_transaksi) month'))
        ->whereYear('tanggl_transaksi', $year_today)->groupby('month')->get();

        $data2 = $data->groupBy('month');
        $res = [];

        for($i = 1; $i<=12; $i++){
            if(isset($data2[$i])){
                $res[] = [
                    'total_sale' => $data2[$i][0]->total_sale,
                    'month' => $i,
                ];
            }
            else{
                $res[] = [
                    'total_sale' => 0,
                    'month' => $i,
                ];
            }
        }

        //pengeluaran tahun ini
        $cari_pengeluaran = DB::table('pembelians')->selectRaw('sum(total_harga) as total_harga')
        ->whereYear('tanggl_transaksi', $year_today)
        ->first();
        $total_pengeluaran = $cari_pengeluaran->total_harga;

        return response()->json([
            $res, $month_today,
            'total_pengeluaran' => $total_pengeluaran,
            "title" => "Grafik Penjualan Tahun ". $year_today
        ]);
    }

    public function laporanBeli(Request $request)
    {
        if ($request->get('year') != '') {
            $year_today = $request->get('year');
        } else {
            $year_today = Carbon::now()->format('Y');
        }
        $month_today = Carbon::now()->format('m');

        // chart pendapatan per tahun
        $months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $pengeluaran = [];

        foreach ($months as $key => $month) {
            $pengeluaran_beli = Pembelian::selectRaw('CAST(sum(total_harga) as UNSIGNED) as total_harga')
                ->selectRaw('YEAR(tanggl_transaksi) year, MONTH(tanggl_transaksi) month')
                ->whereMonth('tanggl_transaksi', '=', $key + 1)
                ->whereYear('tanggl_transaksi', '=', $year_today)
                ->groupby('year','month')
                ->first();

            if (!empty($pengeluaran_beli)) {
                $pengeluaran[$key] = $pengeluaran_beli->total_harga;
            } else {
                $pengeluaran[$key] = 0;
            }
        }

        //pengeluaran tahun ini
        $cari_pengeluaran = DB::table('pembelians')->selectRaw('sum(total_harga) as total_harga')
            ->whereYear('tanggl_transaksi', $year_today)
            ->first();
        $total_pengeluaran = $cari_pengeluaran->total_harga;

        // top supplier beli barang
        $rank_supplier = DB::table('pembelians')
            ->join('pembelian_barangs', 'pembelians.id', '=', 'pembelian_barangs.pembelian_id')
            ->join('suppliers', 'suppliers.id', '=', 'pembelians.supplier_id')
            ->select('suppliers.name_supplier as name_supplier')
            ->selectRaw('cast(sum(pembelian_barangs.qty) as UNSIGNED) as jumlah')
            ->whereYear('pembelians.tanggl_transaksi', $year_today)
            ->groupBy('suppliers.name_supplier')
            ->orderBy('jumlah', 'desc')
            ->limit(1)
            ->get();
        // dd($rank_supplier);

        return view('pages.toplevel.laporan.index2', [
            'year_today' => $year_today, 'month_today' => $month_today,
            'months' => $months, 'pengeluaran' => $pengeluaran,
            'total_pengeluaran' => $total_pengeluaran,
            'rank_supplier' => $rank_supplier
        ]);
    }

    // api supplier get data
    public function apibeli(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $pembelian = Pembelian::with('supplier')->with('barang')
                    ->whereBetween('tanggl_transaksi', array($request->from_date, $request->to_date))
                    ->get();
            } else {
                $pembelian = Pembelian::with('supplier')->with('barang')->get();
            }

            return DataTables::of($pembelian)
            ->addColumn('action', function ($pembelian) {
                return '' .
                '&nbsp;<a href="#mymodal" data-remote="' . route('toplevel.pembelian.show', ['pembelian' => $pembelian->id]) . '" data-toggle="modal" data-target="#mymodal" data-title=" Invoice Number #' . $pembelian->invoice_number . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>'.
                '&nbsp;<a href="' . route('toplevel.pembelian.invoice', ['id' => $pembelian->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>';
            })->rawColumns(['action'])->make(true);
            return response()->toJson(['pembelian' => $pembelian]);
        }
    }

    public function exportExcel()
    {
        return Excel::download(new PembelianExport, 'pembelian.xlsx');
    }

    public function exportPdf()
    {
        $year_today = Carbon::now()->format('Y');
        $pembelians = Pembelian::with('supplier')->with('dtlpembelian.barang')->get();
        $pdf = PDF::loadView('pages.admin.export_data.pembelian_pdf', ['pembelians' => $pembelians, 'year_today' => $year_today] );
        return $pdf->stream('pembelian.pdf');
    }
}
