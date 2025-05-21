<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('stock_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stockable_id');
            $table->string('stockable_type');
            $table->boolean('is_below_minimum')->default(false);
            $table->timestamps();

            $table->unique(['stockable_id', 'stockable_type'], 'unique_stockable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_statuses');
    }
}
