<?php

namespace App\Http\Controllers\Admin;

use App\Barang;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeramalanController extends Controller
{
    public $x = [];
    public $y = [];
    // public $x = [1,2,3,4,5,6,7,8];
    // public $y = [15,22,34,46,54,67,74,80];
    public $n, $x2, $y2, $xy, $a, $b, $all;

    public function index(){
        $data = DB::table('penjualans')
        ->join('penjualan_barangs', 'penjualans.id', '=','penjualan_barangs.penjualan_id')
        ->join('details_barang', 'details_barang.id', '=' ,'penjualan_barangs.barang_id')

        // ->select(DB::raw('SUM(penjualan_barangs.qty) total'), 'details_barang.id' , DB::raw('MONTH(penjualans.       tanggal_transaksi) month'))
        // ->where('product_detail.id', '1')

        ->selectRaw('CAST(sum(penjualan_barangs.qty) as UNSIGNED) as total')
        ->selectRaw('MONTH(penjualans.tanggal_transaksi) month')

        ->groupBy('month')
        ->get();

        $data2 = $data->groupBy('month');
        $res = [];


        for($i = 1; $i<=12; $i++){
            if(isset($data2[$i])){
                $res[] = [
                    'total' => $data2[$i][0]->total,
                    'month' => $i,
                ];
            }
            else{
                $res[] = [
                    'total' => 0,
                    'month' => $i,
                ];
            }
        }

        foreach($data as $item){
            $this->x[] = $item->month;
            $this->y[] = $item->total;
        }

        $this->n  = count($this->x);
        $this->prepare_calculation();
        $this->ab();
        $this->linear_regression();
        return response()->view('pages.admin.peramalan.index', [
            "results" => $this->all,
            $res
        ]);
    }

    public function prepare_calculation(){
        // menghitung x2
        $this->x2 = array_map(function($n){
            return $n * $n;
        }, $this->x);

        // menghitung y2
        $this->y2 = array_map(function($n){
            return $n * $n;
        }, $this->y);

        // menghitung xy
        for ($i=0; $i <$this->n ; $i++) {
            $this->xy[$i] = $this->x[$i] * $this->y[$i];
        }
    }
    public function ab(){
        $n = $this->n;
        $sigmaXY = array_sum($this->xy);
        $sigmaX = array_sum($this->x);
        $sigmaY = array_sum($this->y);
        $sigmaX2 = array_sum($this->x2);
        $sigmaX_2 = $sigmaX * $sigmaX;

        // menghitung nilai b
        $this->b = ($sigmaXY - ($sigmaX * $sigmaY)) / ($sigmaX2 - $sigmaX_2);

        // menghitung nilai a
        $this->a = ($sigmaY - ($this->b * $sigmaX)) / $n;

    }

    public function forecast($xFore){
        $y = $this->a + ($this->b * $xFore);
        return $y;
    }

    public function linear_regression(){

        // $n = 0;
        // foreach($this->x as $xnew){
        //     $this->all[$n] = round($this->forecast($xnew));
        //     $n++;
        // }

        $last = end($this->x);
        for($i = $last+1; $i<=$last+12; $i++){
            $this->all[] = [
                'bulan' => $i - ($last),
                'hasil' => round($this->forecast($i))
            ];
        }

        // $this->all = $this->forecast(2019);
    }

    public function loadBarang(Request $request){
        $data = "";

        if($request->searchTerm){
            $keyword = $request->searchTerm;

            $data = DB::table('barangs')
            ->join('details_barang', 'barangs.id' , '=', 'details_barang.barang_id')
            ->select('details_barang.id','barangs.name_barang')
            ->where("barangs.name_barang", "LIKE", "%$keyword%")->get();
        }
        else{
            $data = DB::table('barangs')
            ->join('details_barang', 'barangs.id' , '=', 'details_barang.barang_id')
            ->select('details_barang.id','barangs.name_barang')
            ->get();
        }

        $res = [];

        foreach ($data as $item) {
            $res[] = [
                "id" => $item->id,
                "text" => $item->name_barang
            ];
        }

        return json_encode($res);
    }

    public function startForecast (Request $request) {
        $data = "";

        if ($request->barang) {
            $year = $request->get('name');

        }
    }

}
