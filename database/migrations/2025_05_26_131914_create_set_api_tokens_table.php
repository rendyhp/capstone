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
        Schema::create('set_api_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('token_name')->nullable();
            $table->string('phone', 18)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_api_tokens');
    }
};
