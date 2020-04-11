<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $supplier_email = $request->get('supplier_email');
        $suppliers = \App\supplier::where('email', 'LIKE', "%$supplier_email%")->paginate(10);

        return view('pages.admin.supplier.index', ['suppliers' => $suppliers]);
    }

    // api data supplier
    public function apisupplier()
    {
        $supplier = Supplier::orderBy('id', 'DESC')->get();
        return DataTables::of($supplier)
            ->addColumn('action', function ($supplier) {
                return ''.
                '&nbsp;<a href="' . route('admin.supplier.edit', ['supplier' => $supplier->id]) . '" class="btn btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></a>' .
                '&nbsp;<a href="' . route('admin.supplier.edit', ['supplier' => $supplier->id]) . '" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-edit"></i></a>' .
                '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="'.$supplier->id.'" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>';
            })->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "name_supplier" => 'required|unique:suppliers|max:255',
            "email" => 'required|unique:suppliers',
            "perusahaan" => "required",
            "no_telphone" => "required|numeric|min:0",
            "address" => "required"
        );
        $messages = array(
            "name_supplier.required" => "file Name tidak boleh kososng!",
            "name_supplier.unique" => "Nama Supplier Sudah Ada!",
            "email.required" => "field Email tidak boleh kosong!",
            "email.unique" => "Email Sudah terdaftar!",
            "perusahaan.required" => "field Nama Perusahaan tidak boleh kosong",
            "no_telphone.required" => "field No Phone Tidak boleh Kosong",
            "no_telphone.numeric" => "Inputan Berupa Angka",
            "address.required" => "isi alamat dengan lengkap",
        );

        $errors = Validator::make($request->all(), $validation, $messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->getMessageBag()->toArray()]);
        }

        $new_supplier = new Supplier;
        $new_supplier->name_supplier = $request->get('name_supplier');
        $new_supplier->email = $request->get('email');
        $new_supplier->perusahaan = $request->get('perusahaan');
        $new_supplier->no_telphone = $request->get('no_telphone');
        $new_supplier->address = $request->get('address');
        $new_supplier->status = "ACTIVE";

        $new_supplier->save();
        // Supplier::create($new_supplier);
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
        $suppliers = Supplier::findOrFail($id);
        return view('pages.admin.supplier.edit', ['supplier' => $suppliers]);
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
        $supplier = Supplier::findOrFail($id);
        $validation = array(
            "name_supplier" => ['required', Rule::unique('suppliers')->ignore($supplier->name_supplier, 'name_supplier')],
            "email" => ['required', Rule::unique('suppliers')->ignore($supplier->email, 'email')],
            "perusahaan" => "required",
            "no_telphone" => "required|numeric|min:0",
            "address" => "required"
        );
        $messages = array(
            "name_supplier.required" => "file Name tidak boleh kososng!",
            "name_supplier.unique" => "Nama Supplier Sudah Ada!",
            "email.required" => "field Email tidak boleh kosong!",
            "email.unique" => "Email Sudah terdaftar!",
            "perusahaan.required" => "field Nama Perusahaan tidak boleh kosong",
            "no_telphone.required" => "field No Phone Tidak boleh Kosong",
            "no_telphone.numeric" => "Inputan Berupa Angka",
            "address.required" => "isi alamat dengan lengkap",
        );

        $supplier->name_supplier = $request->get('name_supplier');
        $supplier->email = $request->get('email');
        $supplier->perusahaan = $request->get('perusahaan');
        $supplier->no_telphone = $request->get('no_telphone');
        $supplier->address = $request->get('address');
        $supplier->status = $request->get('status');

        $supplier->save();
        return redirect()->route('admin.supplier.edit', $id)->with('status', 'Supplier status successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['status' => 'Supplier deleted successfully']);
    }
}
