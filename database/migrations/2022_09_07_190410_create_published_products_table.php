<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PUBLISHED_PRODUCTS', function (Blueprint $table) {
            $table->id();
            $table->integer('priority');
            $table->unsignedBigInteger('PRODUCTS_id');
            $table->unsignedBigInteger('USERS_id');
            $table->unsignedBigInteger('CATEGORY_PRODUCTS_id');
            $table->foreign('PRODUCTS_id')->references('id')->on('PRODUCTS');
            $table->foreign('USERS_id')->references('id')->on('USERS');
            $table->foreign('CATEGORY_PRODUCTS_id')->references('id')->on('CATEGORY_PRODUCTS');
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
        Schema::dropIfExists('PUBLISHED_PRODUCTS');
    }
}
