<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_barangs', function (Blueprint $table) {
            $table->bigInteger('pembelian_id')->unsigned();
            $table->bigInteger('barang_id')->unsigned();
            $table->bigInteger('categories_id')->unsigned();
            $table->integer('qty');
            $table->integer('harga_beli');
            $table->timestamps();

            $table->primary(['pembelian_id', 'categories_id', 'barang_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_barangs');
    }
}