<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Datatables;
use Session;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return view('pages.admin.user.index', [
            'users' => $users
        ]);
    }

    // api data users
    public function apiuser()
    {
        $users = User::orderBy('id', 'DESC')->get();
            return DataTables::of($users)->addColumn('action', function ($users) {
            return '' .
            '&nbsp;<a href="#mymodal" data-remote="' . route('admin.user.show', ['user' => $users->id]) . '" data-toggle="modal" data-target="#mymodal" data-title=" ' . 'Detail User' . ' " class="btn btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></a>' .
            '&nbsp;<a href="'.route('admin.user.edit', ['user' => $users->id]).'" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-edit"></i></a>'.
            '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="' . $users->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>';
        })->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.user.create');
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
            "name" => "required|unique:users",
            "username" => "required|unique:users",
            "email" => "required|unique:users",
            "no_telphone" => "required",
            "address" => "required",
            "password" => "required",
            "roles" => "required",
            "confrime_password" => "required|same:password"
        );
        $messages = array(
            "name.required" => "Field Name Tidak Boleh Kosong",
            "name.unique" => "Name Sudah Ada",
            "username.required" => "Field Username Tidak Boleh Kosong",
            "username.unique" => "Username sudah Ada",
            "no_telphone.required" => "Field tidak Boleh Kosong",
            "address.required" => "Field Address Tidak Boleh Kosong",
            "password.required" => "Field Password Tidak Boleh Kosong",
            "confrime_password.required" => "Field Confrime Password Tidak Boleh Kosong",
            "confrime_password.same" => "Confirm Password harus Match Password",
            "roles.required" => "Filed Role Tidak Boleh kosong"
        );

        $errors = Validator::make($request->all(), $validation, $messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->getMessageBag()->toArray()]);
        }

        $user = new User;
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->no_telphone = $request->get('no_telphone');
        $user->address = $request->get('address');
        $user->status = "ACTIVE";
        $user->password = Hash::make($request->get('password'));

        $image = $request->file('image');
        if ($image) {
            $image_path = $image->store('image-user', 'public');
            $user->image = $image_path;
        }

        $user->save();

        # create data roles
        $name = $request->get('name');
        $role = new Role;
        $role->name = $request->get('name');
        $role->slug = Str::slug($name, '-');

        // var_dump($user, $role);

        $role->save();
        return response()->json(['status', 'Data Successfully Created!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.admin.user.show')->with([
            'user' => $user
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
        $data = User::findOrFail($id);
        return view('pages.admin.user.edit', [
            'user' => $data
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
        $user = User::findOrFail($id);

        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->no_telphone = $request->get('no_telphone');
        $user->address = $request->get('address');
        $user->status = "ACTIVE";

        if ($request->file('image')) {
            if ($user->image && file_exists(storage_path('app/public/' . $user->image))) {
                Storage::delete('app/public/' . $user->image);
            }
            $file = $request->file('image')->store('image-user', 'public');
            $user->image = $file;
        }

        $user->save();

        # update data roles
        $name = $request->get('name');
        $role = Role::findOrFail($id);
        $role->name = $request->get('name');
        $role->slug = Str::slug($name, '-');

        $role->save();
        Session::flash('success', 'User successfully updated');
        return redirect()->route('admin.user.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['status' => 'User deleted successfully']);
    }
}
