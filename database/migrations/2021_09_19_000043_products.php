<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 400);
            $table->string('slug')->unique();
            $table->mediumText('description');
            $table->bigInteger('product_cat_id')->unsigned()->nullable();


            $table->decimal('price', 10, 2, true);
            $table->decimal('high_price', 10, 2, true)->nullable();
            // the storage path of the material to download after payment
            $table->string('item')->nullable();
            // digital
            $table->boolean('digital')->nullable()->default(true)
                ->comment('digital product can be downloaded');
            // percentage discount, optional
            $table->tinyInteger('discount', false, true)->nullable()->default(0);
            $table->boolean('featured')->nullable()->default(false);

            $table->boolean('active')->nullable()->default(true);
            $table->timestamps();

            // $table->foreign('product_cat_id')->references('id')
            //     ->on('product_cats')
            //     ->onDelete("set null")
            //     ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
