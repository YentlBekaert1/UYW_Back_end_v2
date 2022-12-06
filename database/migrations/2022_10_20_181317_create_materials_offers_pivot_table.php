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
        Schema::create('materials_offers_pivot', function (Blueprint $table) {
            $table->foreignId('offers_id')->index();
            $table->foreign('offers_id')->on('offers')->references('id')->cascadeOnDelete();
            $table->foreignId('materials_id')->index();
            $table->foreign('materials_id')->on('materials')->references('id')->cascadeOnDelete();
            $table->primary(['materials_id', 'offers_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials_offers_pivot');
    }
};
