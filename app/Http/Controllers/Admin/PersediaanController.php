<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Category;
use App\Http\Controllers\Controller;
use App\Persediaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PersediaanController extends Controller
{
    public function index() {
        $persediaan = Barang::with('details_barang')->with('category')->get();
        return view('pages.admin.persediaan.index', [
            'persediaan' => $persediaan
        ]);
    }

     // api persediaan
     public function apipersediaan()
     {
        $persediaan = Barang::with('details_barang')->with('category')->orderBy('id', 'DESC')->get();
        return DataTables::of($persediaan)
            ->addColumn('action', function ($persediaan) {
                return '';
            })->rawColumns(['action'])->make(true);
        return response()->toJson(['persediaan' => $persediaan]);
     }


}
