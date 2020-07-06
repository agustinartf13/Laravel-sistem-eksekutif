<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class PeramalanController extends Controller
{
    // public  $x, //input x param
    //         $y, //input y param
    //         $n, //count of data

    //         $x2,
    //         $y2,
    //         $xy,
    //         $a,
    //         $b,

    //         $all; //forecast y value based on regresi linear

    // public function __construct($x=null, $y=null) {
    //     if (!is_null($x) && !is_null($y)) {
    //         $this->x = $x;
    //         $this->y = $y;
    //         $this->index();
    //     }
    // }

    public function index() {

        $data = DB::table('penjualans')
        ->join('penjualan_barangs', 'penjualan.id', '=', 'penjualan_barangs.penjualan_id')
        // if (is_array($this->x) && is_array($this->y)) {
        //     if(count($this->x) == count($this->y)) {
        //         $this->n = count($this->x);

        //         $this->prepare_calculation();
        //         $this->ab();
        //         $this->linear_regression();
        //     } else {
        //         throw new Exception('Jumlah data variabel X daN Y harus sama');
        //     }
        // } else {
        //     throw new Exception('Variabel X dan Y belum didefinisikan');
        // }

        $barangs = Barang::all();
        return view('pages.admin.peramalan.index', [
            'barangs' => $barangs
        ]);
    }

    // public function prepare_calculation() {
    //     // persiapan menghitung x2, y2, dan xy
    //     $this->x2 = array(function($n) {
    //         return $n * $n;
    //     }, $this->y);

    //     for($i=0; $i < $this->n; $i++) {
    //         $this->xy[$i] = $this->x[$i] * $this->y[$i];
    //     }
    // }

    // public function ab(){
    //     //mendapat nilai konstanta A dan B
    //     $a = ((array_sum($this->y) * array_sum($this->x2)) - (array_sum($this->x) * array_sum($this->xy))) / (($this->n * array_sum($this->x2)) - (array_sum($this->x) * array_sum($this->x)));
    //     $this->a = $a;

    //     $b = (($this->n * array_sum($this->xy)) - (array_sum($this->x) * array_sum($this->y))) / (($this->n * array_sum($this->x2)) - (array_sum($this->x) * array_sum($this->x)));
    //     $this->b = $b;
    // }

    // public function forecast($xfore){
    //     $y = $this->a + ($this->b * $xfore);
    //     return $y;
    // }

    // public function linear_regression(){
    //     $n = 0;
    //     foreach($this->x as $xnew){
    //         $this->all[$n] = $this->forecast($xnew);
    //         $n++;
    //     }
    // }

}
