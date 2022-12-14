<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PRODUCTS_IMAGES', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->integer('order');
            $table->unsignedBigInteger('PRODUCTS_id');
            $table->unsignedBigInteger('PRODUCTS_COLORS_id')->nullable();
            $table->foreign('PRODUCTS_id')->references('id')->on('PRODUCTS');
            $table->foreign('PRODUCTS_COLORS_id')->references('id')->on('PRODUCTS_COLORS');
            $table->softDeletes();
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
        Schema::dropIfExists('PRODUCTS_IMAGES');
    }
}
