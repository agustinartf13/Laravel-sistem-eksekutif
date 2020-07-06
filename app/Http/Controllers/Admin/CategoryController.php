<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('pages.admin.categories.index', [
            'categories' => $categories
        ]);
    }

    // api get data category
    public function apicategories()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return DataTables::of($categories)
            ->addColumn('show_photo', function ($categories) {
                if ($categories->image == NULL) {
                    return 'No Image';
                }
                return '<img class="rounded mr-2 mo-mb-2" src="' . asset('storage/' . $categories->image) . '" width="120px" /><br>';
            })->addColumn('action', function ($categories) {
                return ''.
                    '<a href="' . route('admin.categories.edit', ['category' => $categories->id]) . '" class="btn btn-flat btn-warning btn-sm"><i class="fa fa-edit"></i></a>' .
                    '&nbsp;<a href="javascript:void(0)" id="delete"  data-id="' . $categories->id . '" class="delete btn btn-primary btn-sm"><i class="fa fa-trash"></i></ button>';
            })->rawColumns(['show_photo', 'action'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.categories.create');
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
            "name" => "required|unique:categories",
        );
        $messages = array(
            "name.required" => "Field Nama Tidak Boleh Kosong",
            "name.unique" => "Nama Supplier Sudah ada!"
        );

        $errors = Validator::make($request->all(), $validation, $messages);
        if ($errors->fails()) {
            return response()->json(['errors' => $errors->getMessageBag()->toArray()]);
        }

        $name = $request->get('name');
        $new_category = new Category;
        $new_category->name = $name;

        if ($request->file('image')) {
            $image_path = $request->file('image')->store('image-category', 'public');
            $new_category->image = $image_path;
        } else {
            $new_category->image = null;
        }
        $new_category->slug = Str::slug('name', '-');

        $new_category->save();
        // Category::create($category);
        return response()->json(['success', 'Data Added successfully']);
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
        $categories = Category::findOrFail($id);
        return view('pages.admin.categories.edit', ['category' => $categories]);
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
        $name = $request->get('name');
        $slug = $request->get('slug');

        $data = Category::findOrFail($id);
        $data->name = $name;
        $data->slug = $slug;

        if ($request->file('image')) {
            if ($data->image && file_exists(storage_path('app/public/image-category'))) {
                Storage::delete('public' . $data->image);
            }
            $new_image = $request->file('image')->store('image-category', 'public');
            $data->image = $new_image;
        }

        $data->slug = Str::slug($name);

        // var_dump($data);
        $data->save();
        Session::flash('success', 'Categories successfully updated');
        return redirect()->route('admin.categories.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();

        return response()->json(['status' => 'Category deleted successfully']);
    }
}
