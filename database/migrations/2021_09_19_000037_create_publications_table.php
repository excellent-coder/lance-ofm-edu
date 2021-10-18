<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 225);
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('image', 300)->nullable();
            $table->bigInteger('cat_id')->unsigned();
            $table->string('docs', 400);
            $table->string('size')->nullable();
            $table->string('volume')->nullable();
            $table->decimal('price')->nullable()->default(0);
            $table->boolean('featured')->nullable()->default(false);
            $table->boolean('published')->nullable()->default(true);
            $table->timestamps();


            // $table->foreign('cat_id')->references('id')->on('publication_cats')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
