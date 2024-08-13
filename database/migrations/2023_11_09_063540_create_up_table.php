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
        Schema::create('up', function (Blueprint $table) {
            $table->id();
            $table->string('up_nama');
            $table->string('up_alamat');
            $table->float('latitude', 20, 15)->default(0.1);
            $table->float('longitude', 20, 15)->default(0.1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('up');
    }
};