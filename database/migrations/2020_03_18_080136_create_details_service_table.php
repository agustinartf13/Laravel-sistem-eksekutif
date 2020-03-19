<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_service', function (Blueprint $table) {
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('motor_id')->unsigned();
            $table->bigInteger('barang_id')->unsigned();
            $table->string('keluhan');
            $table->enum('tipe_servis', ["BERAT", "RINGAN"]);
            $table->date('time_servis');
            $table->string('km_datang');
            $table->integer('harga_jasa');

            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->primary(['service_id', 'motor_id', 'barang_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details_service');
    }
}