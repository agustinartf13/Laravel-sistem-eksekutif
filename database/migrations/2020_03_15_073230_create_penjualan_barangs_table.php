<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_barangs', function (Blueprint $table) {
            $table->integer('penjualan_id')->unsigned();
            $table->integer('barang_id')->unsigned();
            $table->integer('qty')->unsigned();
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->timestamps();

            $table->primary(['penjualan_id', 'barang_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_barangs');
    }
}
