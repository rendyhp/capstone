<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akhir_terpakai_seharusnyas', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('bahan_id'); 
            $table->foreign('bahan_id')->references('id')->on('bahans'); 
            $table->integer('jumlah');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akhir_terpakai_seharusnyas');
    }
};
