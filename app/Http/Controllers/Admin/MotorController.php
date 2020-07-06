<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Motor;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Session;


class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motor = Motor::all();
        return view('pages.admin.motor.index', [
            'motors' => $motor
        ]);
    }

    //api data motor
    public function apimotor()
    {
        $motors = Motor::orderBy('id', 'DESC')->get();
        return DataTables::of($motors)
            ->addColumn('action', function ($motors) {
                return '<a href="' . route('admin.motor.edit', ['motor' => $motors->id]) . '" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-edit"></i></a>' .
                '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="' . $motors->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>';
            })->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.motor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = array(
            "name" => "required|max:100",
            "tipe_motor" => "required|unique:motors|max:255",
            "jenis" => "required"
        );
        $messages = array(
            "name.required" => "field Nama Motor tidak boleh Kosong!",
            "tipe_motor.unique" => "Tipe Motor Sudah terdaftar!",
            "tipe_motor.required" => "field Tipe Motor tidak boleh Kosong!",
        );

        $errors = Validator::make($request->all(), $validation, $messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->getMessageBag()->toArray()]);
        }

        $new_motor = new Motor;
        $new_motor->name = $request->get('name');
        $new_motor->tipe_motor = $request->get('tipe_motor');
        $new_motor->jenis = $request->get('jenis');

        $new_motor->save();
        return response()->json(['success' => 'Data Added successfully.']);
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (request()->ajax()) {
        //     $motor = Motor::findOrFail($id);
        //     return response()->json(['result' => $motor]);
        // }

        $motors = Motor::findOrFail($id);
        return view('pages.admin.motor.edit', ['motor' => $motors]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $id = $request->get('hidden_id');

        $motor = Motor::findOrFail($id);
        $validation = array(
            "name" => "required",
            "tipe_motor" => ['required', Rule::unique('motors')->ignore($motor->tipe_motor, 'tipe_motor')],
            "jenis" => "required",
        );
        $messages = array(
            "name.required" => "field Nama Motor tidak boleh Kosong!",
            "tipe_motor.unique" => "Tipe Motor Sudah terdaftar!",
            "tipe_motor.required" => "field Tipe Motor tidak boleh Kosong!",
        );

        // $errors = Validator::make($request->all(), $validation, $messages);
        // if ($errors->fails()) {
        //     return response()->json(['errors' => $errors->getMessageBag()->toArray()]);
        // }

        $motor->name = $request->get('name');
        $motor->tipe_motor = $request->get('tipe_motor');
        $motor->jenis = $request->get('jenis');

        $motor->save();
        Session::flash('success', 'Data motor successfully updated');
        return redirect()->route('admin.motor.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $motor = Motor::findOrFail($id);
        $motor->delete();

        return response()->json(['status' => 'Supplier deleted successfully']);
    }
}
