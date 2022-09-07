<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PRODUCTS_PRICES', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 14, 2);
            $table->unsignedBigInteger('PRODUCTS_id');
            $table->foreign('PRODUCTS_id')->references('id')->on('PRODUCTS');
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
        Schema::dropIfExists('PRODUCTS_PRICES');
    }
}
