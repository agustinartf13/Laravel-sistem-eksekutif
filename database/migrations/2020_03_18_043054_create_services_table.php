<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('mekanik_id')->unsigned();
            $table->string('invocie_number');
            $table->date('tanggal_servis');
            $table->string('no_polis');
            $table->string('customer_servis');

            $table->string('total_harga');
            $table->string('sub_total');
            $table->integer('profit');

            $table->enum('status', ["CHECKING", "SERVICE", "FINISH"]);

            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('mekanik_id')->references('id')->on('mekaniks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}