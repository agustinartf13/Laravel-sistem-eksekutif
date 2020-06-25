<?php

namespace App\Http\Controllers\Toplevel;

use App\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeramalanController extends Controller
{
    public function index() {

        $barangs = Barang::all();
        return view('pages.toplevel.peramalan.index', [
            'barangs' => $barangs
        ]);
    }
}
