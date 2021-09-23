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
            $table->bigInteger('publication_cat_id')->unsigned();
            $table->string('docs', 400);
            $table->string('size')->nullable();
            $table->string('vol')->nullable();
            $table->decimal('price')->nullable()->default(0);
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
        Schema::dropIfExists('publications');
    }
}
