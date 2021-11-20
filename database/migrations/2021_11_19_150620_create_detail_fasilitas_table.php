<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailFasilitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_fasilitas', function (Blueprint $table) {
            $table->foreignId('homestay_id')->references('id')->on('homestays');
            $table->foreignId('fasilitas_id')->references('id')->on('fasilitas');
            $table->integer('jumlah');
            $table->timestamps();

            $table->primary(['homestay_id','fasilitas_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_fasilitas');
    }
}
