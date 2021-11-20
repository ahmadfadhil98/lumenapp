<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('nama');
            $table->integer('jk');
            $table->string('no_hp');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('foto');
            $table->timestamps();

            $table->foreignId('id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_users');
    }
}
