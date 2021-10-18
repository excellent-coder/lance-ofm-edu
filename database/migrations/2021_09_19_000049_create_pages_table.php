<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 1000);
            $table->string('slug', 191)->unique('slug');
            $table->longText('description');
            $table->text('excerpt')->nullable();
            $table->string('name')->nullable()
                ->comment("key name use to identify static pages");
            $table->string('image')->nullable();
            $table->boolean('published')->nullable()->default(true);
            $table->integer('position')->nullable()->default(0);
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
        Schema::dropIfExists('pages');
    }
}
