<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('src', 1000);
            $table->bigInteger('part_id')->unsigned()->nullable();
            $table->boolean('active')->nullable()->default(true);
            $table->integer('position')->nullable()->default('0');
            $table->timestamps();

            // $table->foreign('part_id')->references('id')
            //     ->on('image_parts')
            //     ->nullOnDelete()
            //     ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
