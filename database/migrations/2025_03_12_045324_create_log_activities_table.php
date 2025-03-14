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

        Schema::create('log_activities', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id'); 
            $table->string('method');
            $table->unsignedBigInteger('tag_log_activity_id'); 
            $table->foreign('tag_log_activity_id')->references('id')->on('tag_log_activities');
            $table->string('subject');

            $table->string('url');
            $table->string('ip');
            $table->string('agent')->nullable();
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
        Schema::dropIfExists('log_activites');
    }
};
