<?php

namespace App\Http\Controllers\Toplevel;

use App\Barang;
use App\BarangDetail;
use App\Category;
use App\Exports\BarangExport;
use App\Http\Controllers\Controller;
use App\Imports\BarangImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Session;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangs = Barang::with(['details_barang'])->get();
        $categories = Category::all();
        // dd($barangs);
        return view('pages.toplevel.barang.index', [
            'barangs' => $barangs, 'categories' => $categories
        ]);
    }

    // api data barang
    public function apibarang()
    {
        $barangs = Barang::with('category')->with('details_barang')->orderBy('id', 'DESC')->get();
        return DataTables::of($barangs)
            ->addColumn('action', function ($barangs) {
                return ''.
                '<a href="#mymodal" data-remote="' . route('toplevel.barang.show', ['barang' => $barangs->id]) . '" data-toggle="modal" data-target="#mymodal" data-title="' . $barangs->name_barang . '" class="btn btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></a>';
            })->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $barangs = Barang::all();
        return view('pages.toplevel.barang.create', ['barangs' => $barangs, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = array(
            "kode_barang" => "required|unique:barangs|max:255",
            "name_barang" => "required|unique:barangs|max:255",
            "categories_id" => "required",
            "description" => "required",
            "harga_dasar" => "required|numeric",
            "harga_jual" => "required|numeric",
            "stock" => "required|numeric"
        );

        $messages = array(
            "kode_barang.required" => "field Kode Barang tidak boleh Kosong!",
            "kode_barang.unique" => "Kode Barang Sudah Ada!",
            "categories_id.required" => "field Name Category tidak boleh Kosong!",
            "description.required" => "field Description tidak Boleh Kosong!",
            "harga_dasar.required" => "field harga tidak boleh Kosong!",
            "harga_dasar.numeric" => "inputan field ini berupa Angka!",
            "harga_jual.required" => "field harga jual tidak boleh Kosong!",
            "harga_jual.numeric" => "inputan field ini berupa Angka!",
            "stock.required" => "field stock tidak boleh Kosong!",
            "stock.numeric" => "inputan ini berupa Angka!",
        );

        $errors = Validator::make($request->all(), $validation, $messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->getMessageBag()->toArray()]);
        }

        $new_barang = new Barang;
        $new_barang->kode_barang = $request->get('kode_barang');
        $new_barang->name_barang = $request->get('name_barang');
        $new_barang->categories_id = $request->get('categories_id');
        $new_barang->save();

        $barangs_id = $new_barang->id;
        $dtl_barang = new BarangDetail;
        $dtl_barang->barang_id = $barangs_id;
        $dtl_barang->description = $request->get('description');
        $dtl_barang->harga_dasar = $request->get('harga_dasar');
        $dtl_barang->harga_jual = $request->get('harga_jual');
        $dtl_barang->stock = $request->get('stock');

        $image = $request->file('image');
        if ($image) {
            $image_path = $image->store('image-barang', 'public');
            $dtl_barang->image = $image_path;
        }

        $dtl_barang->save();

        // var_dump($new_barang, $dtl_barang);
        // return redirect()->route('toplevel.barang.create')
        //     ->with('status', 'Data successfully created!!');

        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = Barang::with('category', 'details_barang')->findOrFail($id);

        return view('pages.toplevel.barang.show')->with([
            'barang' => $barang
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
        $barangs = Barang::with('category', 'details_barang')->findOrFail($id);
        $categories = Category::all();
        $details_barang = BarangDetail::all();
        // dd($barangs);
        return view('pages.toplevel.barang.edit', [
            'barang' => $barangs, 'categories' => $categories, 'details_barang' => $details_barang
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
        $data_brg = Barang::findOrFail($id);
        $data_brg->kode_barang = $request->get('kode_barang');
        $data_brg->name_barang = $request->get('name_barang');
        $data_brg->categories_id = $request->get('categories_id');
        $data_brg->save();

        $detl_brg = BarangDetail::where('barang_id', $id)->first();
        $new_image = $detl_brg->image;

        if ($request->file('image')) {
            if ($detl_brg->image && file_exists(storage_path('app/public/image-barang'))) {
                Storage::delete('public' . $detl_brg->image);
            }
            $new_image = $request->file('image')->store('image-barang', 'public');
        }
        BarangDetail::where('barang_id', $id)->update([
            'description' => $request->get('description'),
            'harga_dasar' => $request->get('harga_dasar'),
            'harga_jual' => $request->get('harga_jual'),
            'stock' => $request->get('stock'),
            'image' => $new_image
        ]);

        // dd($request->file('image'));
        Session::flash('success', 'Barang status successfully updated');
        return redirect()->route('toplevel.barang.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return response()->json(['status' => 'Barang deleted successfully']);
    }

    public function exportPdf()
    {
        $year_today = Carbon::now()->format('Y');
        $barangs = Barang::with('category', 'details_barang')->get();
        $pdf = PDF::loadView('pages.toplevel.export_data.list_barang_pdf', [
            'barangs' => $barangs, 'year_today' => $year_today
        ]);
        return $pdf->stream('barang.pdf');

    }

    public function exportExcel()
    {
        return Excel::download(new BarangExport, 'listbarang.xlsx');
    }

    public function importExcel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder di dalam folder public
        $file->move('file_barang',$nama_file);

        // import data
        Excel::import(new BarangImport, public_path('/file_barang/'.$nama_file));

        // notifikasi dengan session
        Session::flash('sukses','Data barang Berhasil Diimport!');

        // alihkan halaman kembali
        return redirect()->route('toplevel.barang.index');
    }
}
