<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_size', function (Blueprint $table) {
            $table->id();

            $table->foreignId('color_id')->references('id')->on('colors')
                ->onDelete('cascade');
            $table->foreignId('size_id')->references('id')->on('sizes')
                ->onDelete('cascade');

            $table->integer('quantity');

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
        Schema::dropIfExists('color_size');
    }
}
