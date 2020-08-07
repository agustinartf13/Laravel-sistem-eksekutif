<?php

namespace App\Http\Controllers\Toplevel;

use App\Barang;
use App\BarangDetail;
use App\DetailService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServisRequest;
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
        return view('pages.toplevel.servis.index', [
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
                    '&nbsp;<a href="#mymodal" data-remote="' . route('toplevel.servis.show', $service->id) . '" data-toggle="modal" data-target="#mymodal" data-title="Invoice Number #' . $service->invocie_number . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>' .
                    '&nbsp;<a href="' . route('toplevel.servis.edit', $service->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>' .
                    '&nbsp;<a href="' . route('toplevel.servis.invoice', ['id' => $service->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>' .
                    '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="' . $service->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>';
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
        return view('pages.toplevel.servis.create', [
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
    public function store(ServisRequest $request)
    {
        //create data service
        $new_service = new Service;
        $new_service->created_by = Auth::user()->id;
        $new_service->updated_by = Auth::user()->id;
        $new_service->mekanik_id = $request->get('name_mekanik');
        $new_service->customer_servis = $request->get('name_customer');
        $new_service->alamat = $request->get('alamat');
        $new_service->no_telphone = $request->get('no_telphone');

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

        return redirect()->route('toplevel.servis.index', ['id' => $service_id])->with('status', 'penjualan successfully created');
    }

    public function invoice(Request $request, $id)
    {
        $service = Service::with('mekanik')->with('motor')->with('dtlservice.barang')->findOrFail($id);
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
        $service = Service::with('mekanik')->with('motor')->with('dtlservice.barang')->findOrFail($id);

        return view('pages.toplevel.servis.show')->with([
            'service' => $service
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::with('dtlservice')->findOrFail($id);

        $barangs = Barang::all();
        $mekaniks = Mekanik::all();
        $dtlservice = DetailService::all();
        $motors = Motor::all();

        return view('pages.toplevel.servis.edit', [
            'service' => $service, 'barangs' => $barangs,
            'mekaniks' => $mekaniks, 'dtlservice' => $dtlservice, 'motors' => $motors
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServisRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->updated_by = Auth::user()->id;
        $service->created_by = Auth::user()->id;
        $service->mekanik_id = $request->get('name_mekanik');
        $service->customer_servis = $request->get('name_customer');
        $service->alamat = $request->get('alamat');
        $service->no_telphone = $request->get('no_telphone');

        $service->tanggal_servis =
            date('Y-m-d', strtotime($request->get('tanggal_servis')));

        $service->no_polis = $request->get('no_polis');
        $service->motor_id = $request->get('motor');
        $service->status = $request->get('status');

        // $invoice = Service::get('invocie_number')->last();
        // if ($invoice === null) {
        //     $invoice_no = 1001;
        // } else {
        //     $invoice_no = $invoice->invocie_number + 1;
        // }
        // $service->invocie_number = $invoice_no;

        $service->total_harga = 0;
        $service->profit = 0;
        $service->sub_total = 0;
        $service->save();

        $service_id = $service->id;

        $total_harga = 0;
        $sub_total = 0;
        $profit = 0;

        $service_id = $service->id;

        //kembalikan ke stock
        $dtl_service = DetailService::where('service_id', '=', $service_id)->get();
        foreach ($dtl_service as $detail) {
            $stock = BarangDetail::find($detail->barang_id);
            $stock->stock -= $detail->qty;
            $stock->save();
        }

        //hapus barang
        $dtl_service = DetailService::where('service_id', '=', $service_id)->get();
        foreach ($dtl_service as $detail) {
            $dtl_service = DetailService::where('service_id', '=', $detail->service_id)
                ->where('barang_id', '=', $detail->barang_id)
                ->first();
            $dtl_service->delete();
        }

        // update service
        foreach ($request->get('barang') as $key => $brg) {
            $dtl_service = DetailService::where('service_id', '=', $service_id)
                ->where('barang_id', '=', $brg)
                ->first();

            if ($dtl_service != '') {
                $dtl_service = DetailService::where('service_id', '=', $service_id)
                    ->where('barang_id', '=', $brg)
                    ->first();
            } else {
                $dtl_service = new DetailService;
                $dtl_service->service_id = $service_id;
                $dtl_service->waktu_servis = $request->get('waktu_servis');
                $dtl_service->km_datang = $request->get('km_datang');
                $dtl_service->harga_jasa = $request->get('harga_jasa');
                $dtl_service->keluhan = $request->get('keluhan');
                $dtl_service->tipe_servis = $request->get('tipe_servis');
                $dtl_service->barang_id = $brg;
            }
            $dtl_service->qty = $request->get('qty')[$key];

            $barang = BarangDetail::find($request->get('barang')[$key]);
            $dtl_service->harga_jual = $barang->harga_jual;
            $dtl_service->harga_beli = $barang->harga_dasar;
            $dtl_service->save();

            $total_harga += $dtl_service->harga_Jual * $dtl_service->qty;
            $profit += ($dtl_service->harga_jual - $dtl_service->harga_beli) * $dtl_service->qty;

            $sub_total += ($dtl_service->harga_jual * $dtl_service->qty) + $dtl_service->harga_jasa;

            $new_stock = BarangDetail::find($request->get('barang')[$key]);
            $new_stock->stock -= $request->get('qty')[$key];
            $new_stock->save();
        }

        $service = Service::find($service_id);
        $service->total_harga = $total_harga;
        $service->sub_total = $sub_total;
        $service->profit = $profit;
        $service->save();

        return redirect()->route('toplevel.servis.index', $id)->with('status', 'Service successfully Updated');
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

    public function setStatus(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->status = $request->status;

        $service->save();

        return redirect()->route('toplevel.servis.index')
            ->with('status', 'Status successfully updated');
    }
}
