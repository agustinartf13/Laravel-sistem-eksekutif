<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\BarangDetail;
use App\Category;
use App\DetailPembelian;
use App\Http\Controllers\Controller;
use App\Http\Requests\PembelianRequest;
use App\Pembelian;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::with('supplier')->with('barang')->get();
        return view('pages.admin.pembelian.index', [
            'pembelians' => $pembelian
        ]);
    }

    // api supplier get data
    public function apipembelian()
    {
        $pembelian = Pembelian::with('supplier')->with('barang')->get();
        return DataTables::of($pembelian)
            ->addColumn('action', function ($pembelian) {
                return '' .
                    '&nbsp;<a href="' . route('admin.pembelian.show', ['pembelian' => $pembelian->id]) . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>'.
                    '&nbsp;<a href="' . route('admin.pembelian.edit', ['pembelian' => $pembelian->id]) . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>'.
                    '&nbsp;<a href="' . route('admin.pembelian.invoice', ['id' => $pembelian->id]) . '" class="btn btn-danger btn-sm"><i class="fa fa-print"></i></a>'.
                    '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="' . $pembelian->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>';
            })->rawColumns(['action'])->make(true);
            return response()->toJson(['pembelian' => $pembelian]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pembelians = Pembelian::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        return view('pages.admin.pembelian.create', [
            'pembelians' => $pembelians, 'categories' => $categories, 'suppliers' => $suppliers, 'barangs' => $barangs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PembelianRequest $request)
    {
        $pembelian = new Pembelian;
        $pembelian->created_by = Auth::user()->id;
        $pembelian->updated_by = Auth::user()->id;

        $pembelian->supplier_id = $request->get('supplier');

        $pembelian->tanggl_transaksi = date('Y-m-d', strtotime($request->get('tanggl_transaksi')));
        $invoice = Pembelian::get('invoice_number')->last();

        if ($invoice === null) {
            $invoice_no = 1001;
        } else {
            $invoice_no = $invoice->invoice_number + 1;
        }
        $pembelian->invoice_number = $invoice_no;
        $pembelian->total_harga = 0;
        $pembelian->status = $request->get('status');
        $pembelian->save();
        $pembelian_id = $pembelian->id;

        $total_harga = 0;

        // return var_dump($request->all());

        // lopping data barang form add
        foreach ($request->barang as $key => $brg) {
            $pembelian_detail = new DetailPembelian();
            $pembelian_detail->pembelian_id = $pembelian_id;
            $pembelian_detail->categories_id = $request->categories[$key];
            $pembelian_detail->barang_id = $brg;
            $pembelian_detail->qty = $request->qty[$key];

            $barangs = Barang::find($brg);
            $pembelian_detail->harga_beli = $barangs->details_barang->harga_dasar;
            $pembelian_detail->save();

            $total_harga += $pembelian_detail->harga_beli * $pembelian_detail->qty;

            $new_stock = BarangDetail::find($brg);
            $new_stock->stock += $request->qty[$key];
            $new_stock->save();
        }

        $pembelian = Pembelian::find($pembelian_id);
        $pembelian->total_harga = $total_harga;

        // dd($pembelian_detail, $new_stock);
        $pembelian->save();

        return redirect()->route('admin.pembelian.create')->with('status', 'Pembelian successfully created!');
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
        $pembelians = Pembelian::findOrFail($id);
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $categories = Category::all();

        return view(
            'pages.admin.pembelian.edit',
            [
                'pembelians' => $pembelians, 'barangs' => $barangs,
                'suppliers' => $suppliers, 'categories' => $categories
            ]
        );
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
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->supplier_id = $request->get('supplier');
        $pembelian->updated_by = Auth::user()->id;
        $pembelian->tanggl_transaksi =
            date('Y-m-d', strtotime($request->get('tanggl_transaksi')));

        $pembelian->status = $request->get('status');
        $pembelian->total_harga = 0;
        $pembelian->save();

        // get id pembelian
        $pembelian_id = $pembelian->id;
        $total_harga = 0;

        // kembalikan ke stock
        $detail_pembelian = DetailPembelian::where('pembelian_id', '=', $pembelian_id)->get();
        foreach ($detail_pembelian as $detail) {
            $stock = BarangDetail::find($detail->barang_id);
            $stock->stock -= $detail->qty;
            $stock->save();
        }

        // hapus barang
        $detail_pembelian = DetailPembelian::where('pembelian_id', '=', $pembelian_id)->get();
        foreach ($detail_pembelian as $details) {
            $detail_pembelian = DetailPembelian::where('pembelian_id', '=', $details->pembelian_id)
                ->where('barang_id', '=', $details->barang_id)
                ->first();
            $detail_pembelian->delete();
        }

        // update produk
        foreach ($request->get('barang') as $key => $brg) {
            $detail_pembelian = DetailPembelian::where('pembelian_id', '=', $pembelian_id)
                ->where('barang_id', '=', $brg)
                ->first();

            if ($detail_pembelian != '') {
                $detail_pembelian = DetailPembelian::where('pembelian_id', '=', $pembelian_id)
                    ->where('barang_id', '=', $brg)
                    ->first();
            } else {
                $detail_pembelian = new DetailPembelian;
                $detail_pembelian->pembelian_id = $pembelian_id;
                $detail_pembelian->categories_id = $request->get('categories')[$key];
                $detail_pembelian->barang_id = $brg;
            }
            $detail_pembelian->qty = $request->get('qty')[$key];

            $barang = BarangDetail::find($request->get('barang')[$key]);
            $detail_pembelian->harga_beli = $barang->harga_dasar;
            $detail_pembelian->save();

            $total_harga += $detail_pembelian->harga_beli * $detail_pembelian->qty;

            // update stock
            $new_stock = BarangDetail::find($brg);
            $new_stock->stock += $request->get('qty')[$key];
            $new_stock->save();
        }
        $pembelian = Pembelian::find($pembelian_id);
        $pembelian->total_harga = $total_harga;
        $pembelian->save();

        return redirect()->route('admin.pembelian.edit', $id)
            ->with('status', 'Data successfully Updated');
    }

    public function invoice(Request $request, $id)
    {
        $pembelians = Pembelian::with('dtlpembelian')->findOrFail($id)->get();
        $suppliers = Supplier::all();

        // join table pembelians->barangs->dtlpembelians

        // dd($pembelians);
        return view('pages.admin.pembelian.invoice', [
            'pembelians' => $pembelians, 'suppliers' => $suppliers
        ]);
    }

    public function invoicePrint($id)
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
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();
        return response()->json(['status' => 'Pembelian deleted successfully']);
    }
}