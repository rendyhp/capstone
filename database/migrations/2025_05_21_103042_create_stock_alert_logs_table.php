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
        Schema::create('stock_alert_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stockable_id');
            $table->string('stockable_type'); // 'App\Models\Bahan' atau 'App\Models\Barang'
            $table->date('alert_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_alert_logs');
    }
};
