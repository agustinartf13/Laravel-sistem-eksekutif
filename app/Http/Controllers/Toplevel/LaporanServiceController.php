<?php

namespace App\Http\Controllers\Toplevel;

use App\Http\Controllers\Controller;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\ServiceExport;

use PDF;

class LaporanServiceController extends Controller
{
    public function totalSalePerMonth(Request $request){

        if ($request->get('year') != '') {
            $year_today = $request->get('year');
        } else {
            $year_today = Carbon::now()->format('Y');
        }
        $month_today = Carbon::now()->format('m');

        // salePerMonth Profit Service
        $data_service_profit = DB::table('services')->select(DB::raw('sum(profit) as `total_sale_profit`'), DB::raw('MONTH(tanggal_servis) month'))
        ->whereYear('tanggal_servis', $year_today)->groupby('month')->get();

        $data_profit = $data_service_profit->groupBy('month');
        $res_service_profit = [];

        for($i = 1; $i<=12; $i++){
            if(isset($data_profit[$i])){
                $res_service_profit[] = [
                    'total_sale_profit' => $data_profit[$i][0]->total_sale_profit,
                    'month' => $i,
                ];
            }
            else{
                $res_service_profit[] = [
                    'total_sale_profit' => 0,
                    'month' => $i,
                ];
            }
        }

        // salePerMonth Profit Jasa
        $data_service_jasa = DB::table('services')
        ->join('details_service', 'services.id', '=', 'details_service.service_id')
        ->select(DB::raw('sum(details_service.harga_jasa) as `total_sale_jasa`'), DB::raw('MONTH(tanggal_servis) month'))
        ->whereYear('tanggal_servis', $year_today)->groupby('month')->get();

        $data_jasa = $data_service_jasa->groupBy('month');
        $res_service_jasa = [];

        for($i = 1; $i<=12; $i++){
            if(isset($data_jasa[$i])){
                $res_service_jasa[] = [
                    'total_sale_jasa' => $data_jasa[$i][0]->total_sale_jasa,
                    'month' => $i,
                ];
            }
            else{
                $res_service_jasa[] = [
                    'total_sale_jasa' => 0,
                    'month' => $i,
                ];
            }
        }

        // salePerMonth Profit Subtotal
        $data_service_subtotal = DB::table('services')->select(DB::raw('sum(sub_total) as `total_sale_subtotal`'), DB::raw('MONTH(tanggal_servis) month'))
        ->whereYear('tanggal_servis', $year_today)->groupby('month')->get();

        $data_subtotal = $data_service_subtotal->groupBy('month');
        $res_service_subtotal = [];

        for($i = 1; $i<=12; $i++){
            if(isset($data_subtotal[$i])){
                $res_service_subtotal[] = [
                    'total_sale_subtotal' => $data_subtotal[$i][0]->total_sale_subtotal,
                    'month' => $i,
                ];
            }
            else{
                $res_service_subtotal[] = [
                    'total_sale_subtotal' => 0,
                    'month' => $i,
                ];
            }
        }

        // query pendapatan jasa
        $cari_jasa = DB::table('services')
            ->join('details_service', 'services.id', '=', 'details_service.service_id')
            ->selectRaw('sum(details_service.harga_jasa)as harga_jasa')
            ->whereYear('services.tanggal_servis', $year_today)  //mencari omset
            ->first();
        $total_jasa = $cari_jasa->harga_jasa;

        // query omset service tahun ini
        $cari_omset = DB::table('services')
            ->join('details_service', 'services.id', '=', 'details_service.service_id')
            ->selectRaw('sum(sub_total)as omset')
            ->whereYear('services.tanggal_servis', $year_today)  //mencari omset
            ->first();
        $total_omset = $cari_omset->omset;
        // dd($total_omset);

        // query mencari profit bulan ini
        $cari_profit = DB::table('services')
            ->selectRaw('sum(profit) as profit')
            ->whereYear('services.tanggal_servis', $year_today)  //mencari profit
            ->first();
        $total_profit = $cari_profit->profit;
        // dd($total_profit);

        return response()->json([
            $res_service_profit,
            $res_service_jasa,
            $res_service_subtotal,
            $month_today,
            'total_profit' => $total_profit,
            'total_omset' => $total_omset,
            'total_jasa' => $total_jasa,
            "title" => "Grafik Penjualan Tahun ". $year_today
        ]);

        // dd($res_service_profit, $month_today, $res_service_jasa, $res_service_subtotal);
    }

    public function laporanService(Request $request)
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

        // query pendapatan jasa
        $cari_jasa = DB::table('services')
            ->join('details_service', 'services.id', '=', 'details_service.service_id')
            ->selectRaw('sum(details_service.harga_jasa)as harga_jasa')
            ->whereYear('services.tanggal_servis', $year_today)  //mencari omset
            ->first();
        $total_jasa = $cari_jasa->harga_jasa;

        // query omset service tahun ini
        $cari_omset = DB::table('services')
            ->join('details_service', 'services.id', '=', 'details_service.service_id')
            ->selectRaw('sum(sub_total)as omset')
            ->whereYear('services.tanggal_servis', $year_today)  //mencari omset
            ->first();
        $total_omset = $cari_omset->omset;
        // dd($total_omset);

        // query mencari profit bulan ini
        $cari_profit = DB::table('services')
            ->selectRaw('sum(profit) as profit')
            ->whereYear('services.tanggal_servis', $year_today)  //mencari profit
            ->first();
        $total_profit = $cari_profit->profit;
        // dd($total_profit);

        //range custemer servis
        $cari_customer = DB::table('services')->selectRaw('sum(customer_servis) as customer')
            ->whereYear('services.tanggal_servis', $year_today)
            ->first();
        $total_customer = $cari_customer->customer;
        // dd($total_customer);

        // customer paling banyak ganti sparepart
        $rank_customer = DB::table('services')
            ->join('details_service', 'services.id', '=', 'details_service.service_id')
            ->select('services.customer_servis as customer_servis')
            ->selectRaw('cast(sum(details_service.qty)as UNSIGNED) as jumlah')
            ->whereYear('services.tanggal_servis', $year_today)
            ->groupBy('services.customer_servis')
            ->orderBy('jumlah', 'DESC')
            ->limit(1)
            ->get();
        // dd($rank_customer);

        // sparepart paling banyak di beli
        $rank_barang = DB::table('services')
            ->join('details_service', 'services.id', '=', 'details_service.service_id')
            ->join('barangs', 'barangs.id', '=', 'details_service.barang_id')
            ->join('details_barang', 'barangs.id', '=', 'details_barang.barang_id')
            ->select('barangs.name_barang as name_barang')
            ->selectRaw('cast(sum(details_service.qty)as UNSIGNED) as jumlah')
            ->whereYear('services.tanggal_servis', $year_today)
            ->groupBy('barangs.name_barang')
            ->orderBy('jumlah', 'desc')
            ->limit(1)
            ->get();
        // dd($rank_barang);

        return view('pages.toplevel.laporan.index3', [
            'year_today' => $year_today, 'month_today' => $month_today,
            'months' => $months, 'profit' => $profit,
            'total_omset' => $total_omset, 'total_profit' => $total_profit,
            'total_customer' => $total_customer, 'rank_customer' => $rank_customer,
            'rank_barang' => $rank_barang , 'total_jasa' => $total_jasa, 'jasa' => $jasa, 'omset' => $omset
        ]);
    }

   // api data service datatabls
   public function apiservice(Request $request)
   {
       if (request()->ajax()) {
           if (!empty($request->from_date)) {
               $service = Service::with('dtlservice')->with('motor')
               ->whereBetween('tanggal_servis', array($request->from_date, $request->to_date))
               ->orderBy('id', 'DESC')
               ->get();
           } else {
               $service = Service::with('dtlservice')->with('motor')->orderBy('id', 'DESC')
               ->get();
           }

           return DataTables::of($service)
           ->addColumn('action', function ($service) {
               return '' .
                   '&nbsp;<a href="#mymodal" data-remote="' . route('toplevel.servis.show', $service->id) . '" data-toggle="modal" data-target="#mymodal" data-title="Invoice Number #' . $service->invocie_number . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>' .
                   '&nbsp;<a href="' . route('toplevel.servis.invoice', ['id' => $service->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>';
           })->rawColumns(['action'])->make(true);
           return response()->toJson(['service' => $service]);

       }
   }

    public function exportExcel()
    {
        return Excel::download(new ServiceExport, 'service.xlsx');
    }

    public function exportPdf()
    {
        $year_today = Carbon::now()->format('Y');
        $services = Service::with('mekanik')->with('motor')->with('dtlservice.barang')->get();
        $pdf = PDF::loadView('pages.admin.export_data.service_pdf', ['services' => $services, 'year_today' => $year_today] );
        return $pdf->stream('service.pdf');
    }
}
