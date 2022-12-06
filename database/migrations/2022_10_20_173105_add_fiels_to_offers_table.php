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
        Schema::table('offers', function (Blueprint $table) {
            $table->foreignId('categories_id');
            $table->foreign('categories_id')->on('categories')->references('id')->cascadeOnDelete();

            $table->foreignId('approaches_id');
            $table->foreign('approaches_id')->on('approaches')->references('id')->cascadeOnDelete();

            $table->string('url')->nullable();
            $table->string('contact')->nullable();
            $table->string('job')->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->string('is_reported')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            //
        });
    }
};
