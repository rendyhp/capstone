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
        Schema::create('komposisi_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id'); 
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->unsignedBigInteger('bahan_id'); 
            $table->foreign('bahan_id')->references('id')->on('bahans');

            $table->decimal('jumlah', 12, 3);

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
        Schema::dropIfExists('komposisi_menus');
    }
};
