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
        Schema::create('ulp', function (Blueprint $table) {
            $table->id();
            $table->string('ulp_nama');
            $table->string('ulp_alamat');
            $table->float('ulp_latitude', 20, 15)->default(0.0);
            $table->float('ulp_longitude', 20, 15)->default(0.0);
            $table->unsignedBigInteger('up_id');
            $table->foreign('up_id')->references('id')->on('up')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulp');
    }
};
