<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_trans');
            $table->enum('trans_jenis',['Masuk','Keluar']);
            $table->date('tanggal_trans');
            $table->unsignedBigInteger('up_id');
            $table->unsignedBigInteger('ulp_id')->nullable();
            $table->string('pemberi')->nullable();
            $table->string('penerima')->nullable();

            $table->unsignedBigInteger('created_by'); // Kolom yang akan digunakan sebagai foreign key
            $table->dateTime('created_at', $precision = 0);
            
            $table->foreign('created_by')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('up_id')->references('id')->on('up')
                  ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('ulp_id')->references('id')->on('ulp')
                  ->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};