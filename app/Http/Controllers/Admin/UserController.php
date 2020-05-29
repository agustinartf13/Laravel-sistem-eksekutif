<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserValidRequest;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Datatables;


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
            '&nbsp;<a href="'.route('admin.user.show', ['user' => $users->id]).'" class="btn btn-info btn-flat btn-sm"><i class="fa fa-eye"></i></a>'.
            '&nbsp;<a href="'.route('admin.user.edit', ['user' => $users->id]).'" class="btn btn-warning btn-flat btn-sm"><i class="fa fa-edit"></i></a>'.
            '&nbsp;<button type="button" name="delete" id="' . $users->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i></button>';
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
    public function store(UserValidRequest $request)
    {
        $user = new User;
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->no_telphone = $request->get('no_telphone');
        $user->about = $request->get('about');
        $user->address = $request->get('address');
        $user->gender = $request->get('gender');
        $user->status = "ACTIVE";
        $user->password = Hash::make($request->get('password'));

        $image = $request->file('image');
        if ($image) {
            $image_path = $image->store('image-user', 'public');
            $user->image = $image_path;
        }
        # create data roles
        $name = $request->get('name');
        $role = new Role;
        $role->name = $request->get('name');
        $role->slug = Str::slug($name, '-');

        // var_dump($user, $role);

        $user->save();
        $role->save();
        return redirect()->route('admin.user.create')
            ->with('status', 'Data successfully created!!');
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
        $user->about = $request->get('about');
        $user->no_telphone = $request->get('no_telphone');
        $user->address = $request->get('address');
        $user->gender = $request->get('gender');
        $user->status = $request->get('status');

        if ($request->file('image')) {
            if ($user->image && file_exists(storage_path('app/public/' . $user->image))) {
                Storage::delete('app/public/' . $user->image);
            }
            $file = $request->file('image')->store('image-user', 'public');
            $user->image = $file;
        }
        $user->save();
        return redirect()->route('admin.user.index', [
            'id' => $id
        ])->with('status', 'User successfully Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = User::findOrFail($id);
        if ($delete->image) {
            Storage::delete('public/' . $delete->image);
            $delete->delete();
        } else {
            $delete->delete();
        }
        return redirect()->route('admin.user.index')
            ->with('status', 'User successfully deleted!!');
    }
}
