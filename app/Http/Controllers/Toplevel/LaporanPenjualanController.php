<?php

namespace App\Http\Controllers\Toplevel;

use App\Barang;
use App\Http\Controllers\Controller;
use App\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LaporanPenjualanController extends Controller
{
    public function laporanJual(Request $request)
    {
        if ($request->get('year') != '') {
            $year_today = $request->get('year');
        } else {
            $year_today = Carbon::now()->format('Y');
        }
        $month_today = Carbon::now()->format('m');

        // chart pendapatan di tahun
        $months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $profit = [];

        foreach ($months as $key => $month) {
            $penjualan_laba = Penjualan::selectRaw('CAST(sum(profit) as UNSIGNED) as profit')
            ->selectRaw('YEAR(tanggal_transaksi) year, MONTH(tanggal_transaksi) month')
            ->whereMonth('tanggal_transaksi', '=', $key + 1)
            ->whereYear('tanggal_transaksi', '=', $year_today)
            ->groupBy('year', 'month')
            ->first();

            if (!empty($penjualan_laba)) {
                $profit[$key] = $penjualan_laba->profit;
            } else {
                $profit[$key] = 0;
            }
        }

        // chart barang laku bulanan
        // $penjualan2 = DB::table('penjualans')
        //     ->join('penjualan_barangs', 'penjualans.id', 'penjualan_barangs.penjualan_id')
        //     ->join('barangs', 'barangs.id', '=', 'penjualan_barangs.barang_id')
        //     ->join('categories', 'barangs.categories_id', '=', 'categories.id')
        //     ->select('categories.name as name')
        //     ->selectRaw('cast(sum(penjualan_barangs.qty)as UNSIGNED)as y')
        //     ->whereYear('penjualans.tanggal_transaksi', $year_today)
        //     ->groupBy('categories.name')
        //     ->orderBy('barangs.name_barang','asc')
        //     ->get();
        // dd($penjualan2);

        // query omset tahun ini
        $cari_omset = DB::table('penjualans')->selectRaw('sum(total_harga)as omset')
            ->whereYear('penjualans.tanggal_transaksi', $year_today)
            ->first();
        $total_omset = $cari_omset->omset;

        // query mencari profit bulan ini
        $cari_profit = DB::table('penjualans')->selectRaw('sum(profit)as profit')
            ->whereYear('penjualans.tanggal_transaksi', $year_today)
            ->first();
        $total_profit = $cari_profit->profit;

        $name_barangs = [];
        $month_a = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
        $search_barang = Barang::orderBy('name_barang', 'asc')->get();

        foreach ($search_barang as $key2 => $sb) {
            $name_barangs[$key2]['name'] = $sb->name_barang;

            foreach ($month_a as $key => $month) {
                $penjualan3 = DB::table('penjualans')
                    ->join('penjualan_barangs', 'penjualans.id', '=', 'penjualan_barangs.penjualan_id')
                    ->join('barangs', 'barangs.id', '=', 'penjualan_barangs.barang_id')
                    ->select('barangs.name_barang as name_barang')
                    ->selectRaw('cast(sum(penjualan_barangs.qty)as UNSIGNED)as y')
                    ->where('barangs.name_barang', $sb->name_barang)
                    ->whereMonth('penjualans.tanggal_transaksi', $month)
                    ->whereYear('penjualans.tanggal_transaksi', $year_today)
                    ->groupBy('barangs.name_barang')
                    ->get();

                if (@$penjualan3[0]->y != null) {
                    $name_barangs[$key2]['data'][$key] = $penjualan3[0]->y;
                } else {
                    $name_barangs[$key2]['data'][$key] = 0;
                }
            }
        }

        $terjual_qty = DB::table('penjualans')
            ->join('penjualan_barangs', 'penjualans.id', '=', 'penjualan_barangs.penjualan_id')
            ->selectRaw('cast(sum(penjualan_barangs.qty)as UNSIGNED) as y')
            ->whereYear('penjualans.tanggal_transaksi', $year_today)
            ->get();
        $terjual_qty = $terjual_qty[0]->y;


        // top customer buyer
        $rank_customer = DB::table('penjualans')
            ->join('penjualan_barangs', 'penjualans.id', '=', 'penjualan_barangs.penjualan_id')
            ->select('penjualans.name_pembeli as name_pembeli')
            ->selectRaw('cast(sum(penjualan_barangs.qty)as UNSIGNED)as jumlah')
            ->whereYear('penjualans.tanggal_transaksi', $year_today)
            ->groupBy('penjualans.name_pembeli')
            ->orderBy('jumlah', 'desc')
            ->limit(1)
            ->get();

        // barang paling banyak laku
        $rank_barang = DB::table('penjualans')
            ->join('penjualan_barangs', 'penjualans.id', '=', 'penjualan_barangs.penjualan_id')
            ->join('barangs', 'barangs.id', '=', 'penjualan_barangs.barang_id')
            ->select('barangs.name_barang as name_barang')
            ->selectRaw('cast(sum(penjualan_barangs.qty)as UNSIGNED) as jumlah')
            ->whereYear('penjualans.tanggal_transaksi', $year_today)
            ->groupBy('barangs.name_barang')
            ->orderBy('jumlah', 'desc')
            ->limit(1)
            ->get();

        return view('pages.toplevel.laporan.index', [
            'year_today' => $year_today, 'month_today' => $month_today,
            'months' => $months, 'profit' => $profit, 'total_profit' => $total_profit, 'total_omset' => $total_omset, 'rank_barang' => $rank_barang, 'rank_customer' => $rank_customer, 'terjual_qty' => $terjual_qty, 'name_barangs' => $name_barangs,
        ]);
    }

      // api supplier get data
      public function apijual(Request $request)
      {
        //datatabels
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $penjualan = Penjualan::with('barangs')
                ->whereBetween('tanggal_transaksi', array($request->from_date, $request->to_date))
                ->get();
            } else {
                $penjualan = Penjualan::with('barangs')->get();
            }

            return DataTables::of($penjualan)
                ->addColumn('action', function ($penjualan) {
                    return '' .
                    '&nbsp;<a href="#mymodal" data-remote="' . route('admin.penjualan.show', ['penjualan' => $penjualan->id]) . '" data-toggle="modal" data-target="#mymodal" data-target="#mymodal" data-title=" Invoice Number #'. $penjualan->invoice_number . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>'.
                    '&nbsp;<a href="' . route('admin.penjualan.invoice', ['id' => $penjualan->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>';
                })->rawColumns(['action'])->make(true);

        }
      }
}
