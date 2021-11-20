<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->foreignId('homestay_id')->references('id')->on('homestays');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->double('rating');
            $table->text('komentar');
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
        Schema::dropIfExists('reviews');
    }
}
