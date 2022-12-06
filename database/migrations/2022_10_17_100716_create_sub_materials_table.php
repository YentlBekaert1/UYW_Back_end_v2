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
        Schema::create('sub_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_nl')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_fr')->nullable();
            $table->foreignId('material_id');
            $table->foreign('material_id')->on('materials')->references('id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_materials');
    }
};
