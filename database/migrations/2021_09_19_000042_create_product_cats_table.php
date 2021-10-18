<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger('super_parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('slug')->unique();

            $table->foreign('parent_id')->references('id')
                ->on('product_cats')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('super_parent_id')->references('id')
                ->on('product_cats')
                ->onDelete('set null')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('product_cats');
    }
}
