<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('cascade');

            $table->unsignedBigInteger('bahan_id');

            $table->foreign('bahan_id')->references('id')->on('bahans');
            $table->decimal('jumlah', 12, 3);
            $table->unsignedBigInteger('satuan_id');
            $table->foreign('satuan_id')->references('id')->on('satuans');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_details');
    }
};
