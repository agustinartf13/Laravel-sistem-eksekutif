<?php

namespace App\Http\Controllers\Toplevel;

use App\Http\Controllers\Controller;
use App\Pembelian;
use App\Penjualan;
use App\Service;
use App\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request) {

        if ($request->get('year') != '') {
            $year_today = $request->get('year');
        } else {
            $year_today = Carbon::now()->format('Y');
        }
        $month_today = Carbon::now()->format('m');

        $penjualan = Penjualan::count();

        $cari_jasa = DB::table('services')
        ->join('details_service', 'services.id', '=', 'details_service.service_id')
        ->selectRaw('sum(details_service.harga_jasa)as harga_jasa')
        ->whereYear('services.tanggal_servis', $year_today)  //mencari omset
        ->first();
        $total_jasa = $cari_jasa->harga_jasa;

        $cari_omset = DB::table('penjualans')->selectRaw('sum(total_harga)as omset')
            ->whereYear('penjualans.tanggal_transaksi', $year_today)
            ->first();
        $total_omset = $cari_omset->omset;


        $terjual_qty = DB::table('penjualans')
            ->join('penjualan_barangs', 'penjualans.id', '=', 'penjualan_barangs.penjualan_id')
            ->selectRaw('cast(sum(penjualan_barangs.qty)as UNSIGNED) as y')
            ->whereYear('penjualans.tanggal_transaksi', $year_today)
            ->get();
        $terjual_qty = $terjual_qty[0]->y;

        $cari_pengeluaran = DB::table('pembelians')->selectRaw('sum(total_harga) as total_harga')
            ->whereYear('tanggl_transaksi', $year_today)
            ->first();
        $total_pengeluaran = $cari_pengeluaran->total_harga;

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

        $cari_profit = DB::table('services')
            ->selectRaw('sum(profit) as profit')
            ->whereYear('services.tanggal_servis', $year_today)  //mencari profit
            ->first();
        $total_profit = $cari_profit->profit;

        // chart pendapatan di tahun
        $months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $profit = [];

        foreach ($months as $key => $month) {
            $service_laba = Service::selectRaw('CAST(sum(profit) as UNSIGNED) as profit')
            ->selectRaw('YEAR(tanggal_servis) year, MONTH(tanggal_servis) month')
            ->whereMonth('tanggal_servis', '=', $key + 1)
            ->whereYear('tanggal_servis', '=', $year_today)
            ->groupBy('year', 'month')
            ->first();

            if (!empty($service_laba)) {
                $profit[$key] = $service_laba->profit;
            } else {
                $profit[$key] = 0;
            }
        }

        $month_a = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $jasa = [];

        foreach ($month_a as $key => $month) {
            $jasa_laba = DB::table('services')
            ->join('details_service', 'services.id', '=', 'details_service.service_id')
            ->selectRaw('CAST(sum(details_service.harga_jasa) as UNSIGNED) as jasa')
            ->selectRaw('YEAR(tanggal_servis) year, MONTH(tanggal_servis) month')
            ->whereMonth('tanggal_servis', '=', $key + 1)
            ->whereYear('tanggal_servis', '=', $year_today)
            ->groupBy('year', 'month')
            ->first();

            if (!empty($jasa_laba)) {
                $jasa[$key] = $jasa_laba->jasa;
            } else {
                $jasa[$key] = 0;
            }
        }

        $month_b = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        $omset = [];

        foreach ($month_b as $key => $month) {
            $omset_a = DB::table('services')
            ->selectRaw('CAST(sum(sub_total) as UNSIGNED) as omset')
            ->selectRaw('YEAR(tanggal_servis) year, MONTH(tanggal_servis) month')
            ->whereMonth('tanggal_servis', '=', $key + 1)
            ->whereYear('tanggal_servis', '=', $year_today)
            ->groupBy('year', 'month')
            ->first();

            if (!empty($omset_a)) {
                $omset[$key] = $omset_a->omset;
            } else {
                $omset[$key] = 0;
            }
        }

        return view('pages.toplevel.dashboard')->with([
            'penjualan' => $penjualan, 'terjual_qty' => $terjual_qty,
            'total_omset' => $total_omset, 'total_jasa' => $total_jasa,
            'total_pengeluaran' => $total_pengeluaran, 'year_today' => $year_today,
            'pengeluaran' => $pengeluaran, 'total_profit' => $total_profit, 'profit' => $profit,
            'omset' => $omset, 'jasa' => $jasa
        ]);
    }

    public function showData(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $penjualan = Penjualan::with('dtlpenjualans.barangs')
                ->whereBetween('tanggal_transaksi', array($request->from_date, $request->to_date))
                ->get();
            } else {
                $penjualan = Penjualan::with('dtlpenjualans.barangs')->get();
            }

            return DataTables::of($penjualan)
                ->addColumn('action', function ($penjualan) {
                    return '' .
                    '&nbsp;<a href="#mymodal" data-remote="' . route('toplevel.penjualan.show', ['penjualan' => $penjualan->id]) . '" data-toggle="modal" data-target="#mymodal" data-target="#mymodal" data-title=" Invoice Number #'. $penjualan->invoice_number . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>'.
                    '&nbsp;<a href="' . route('toplevel.penjualan.invoice', ['id' => $penjualan->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>';
                })->rawColumns(['action'])->make(true);
        }
    }
}
