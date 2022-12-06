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
        Schema::create('sub_materials_offers_pivot', function (Blueprint $table) {
            $table->foreignId('offers_id')->index();
            $table->foreign('offers_id')->on('offers')->references('id')->cascadeOnDelete();
            $table->foreignId('sub_materials_id')->index();
            $table->foreign('sub_materials_id')->on('sub_materials')->references('id')->cascadeOnDelete();
            $table->primary(['sub_materials_id', 'offers_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_materials_offers_pivot');
    }
};
