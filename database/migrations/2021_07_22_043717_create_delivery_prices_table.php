<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_method_id')->unsigned();
            $table->mediumInteger('state_id')->nullable()->unsigned();
            $table->mediumInteger('city_id')->nullable()->unsigned();
            $table->integer('product_cat_id')->nullable()->unsigned();
            $table->bigInteger('product_id')->nullable()->unsigned();
            $table->decimal('price')->unsigned();
            $table->timestamps();

            // foreign keys
            $table->foreign('delivery_method_id')->references('id')
                ->on('delivery_methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('state_id')->references('id')
                ->on('states')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('city_id')->references('id')
                ->on('cities')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('product_cat_id')->references('id')
                ->on('product_cats')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('product_id')->references('id')
                ->on('products')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_prices');
    }
}
