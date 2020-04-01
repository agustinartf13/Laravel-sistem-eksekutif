<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\BarangDetail;
use App\DetailService;
use App\Http\Controllers\Controller;
use App\Mekanik;
use App\Motor;
use App\Service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::with('dtlservice')->with('motor')->get();
        return view('pages.admin.servis.index', [
            'service' => $service
        ]);
    }

    // api data Service
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangs = Barang::all();
        $users = User::all();
        $mekaniks = Mekanik::all();
        $motors = Motor::all();
        return view('pages.admin.servis.create', [
            'barangs' => $barangs, 'users' => $users,
            'mekaniks' => $mekaniks, 'motors' => $motors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create data service
        $new_service = new Service;
        $new_service->created_by = Auth::user()->id;
        $new_service->updated_by = Auth::user()->id;
        $new_service->mekanik_id = $request->get('name_mekanik');
        $new_service->customer_servis = $request->get('name_customer');

        $new_service->tanggal_servis =
            date('Y-m-d', strtotime($request->get('tanggal_servis')));

        $new_service->no_polis = $request->get('no_polis');
        $new_service->motor_id = $request->get('motor');
        $new_service->status = $request->get('status');



        $invoice = Service::get('invocie_number')->last();
        if ($invoice === null) {
            $invoice_no = 1001;
        } else {
            $invoice_no = $invoice->invocie_number + 1;
        }
        $new_service->invocie_number = $invoice_no;
        $new_service->total_harga = 0;
        $new_service->profit = 0;
        $new_service->sub_total = 0;
        $new_service->save();

        $service_id = $new_service->id;

        $total_harga = 0;
        $sub_total = 0;
        $profit = 0;

        $service_id = $new_service->id;

        // insert data details service
        foreach ($request->get('barang') as $key => $brg) {
            $new_dtlservice = new DetailService;
            $new_dtlservice->service_id = $service_id;
            $new_dtlservice->waktu_servis = $request->get('waktu_servis');
            $new_dtlservice->km_datang = $request->get('km_datang');
            $new_dtlservice->harga_jasa = $request->get('harga_jasa');
            $new_dtlservice->keluhan = $request->get('keluhan');
            $new_dtlservice->tipe_servis = $request->get('tipe_servis');

            $new_dtlservice->barang_id = $brg;
            $new_dtlservice->qty = $request->get('qty')[$key];

            $barang = BarangDetail::find($request->get('barang')[$key]);
            $new_dtlservice->harga_jual = $barang->harga_jual;
            $new_dtlservice->harga_beli = $barang->harga_dasar;
            $new_dtlservice->save();

            $total_harga += $new_dtlservice->harga_Jual * $new_dtlservice->qty;
            $profit += ($new_dtlservice->harga_jual - $new_dtlservice->harga_beli) * $new_dtlservice->qty;
            $sub_total += ($new_dtlservice->harga_jual * $new_dtlservice->qty) + $new_dtlservice->harga_jasa;


            $new_stock = BarangDetail::find($request->get('barang')[$key]);
            $new_stock->stock -= $request->get('qty')[$key];
            $new_stock->save();
        }

        $new_service = Service::find($service_id);
        $new_service->total_harga = $total_harga;
        $new_service->sub_total = $sub_total;
        $new_service->profit = $profit;
        $new_service->save();

        return redirect()->route('admin.servis.create', ['id' => $service_id])->with('status', 'penjualan successfully created');
    }

    public function invoice(Request $request, $id)
    {
        $service = Service::with('mekanik')->with('dtlbarang')->with('dtlservice')->with('motor')->findOrFail($id);
        return view('pages.admin.servis.invoice', [
            'service' => $service
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = Service::findOrFail($id);
        $barangs = Barang::all();
        return view('pages.admin.penjualan.edit', [
            'services' => $services, 'barangs' => $barangs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['status' => 'Service deleted successfully']);
    }
}