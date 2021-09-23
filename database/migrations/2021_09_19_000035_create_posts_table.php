<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('post_cat_id')->unsigned()->nullable();
            $table->string('title', 300);
            $table->string('slug')->unique();
            $table->longText('description');

            $table->text('excerpt')->nullable();
            $table->boolean('published')->nullable()->default(1);
            $table->boolean('featured')->nullable()->default(0);
            $table->string('image', 300)->nullable();
            $table->timestamps();

            // $table->foreign('post_cat_id')->references('id')
            //     ->on('post_cats')
            //     ->onDelete('set null')
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
        Schema::dropIfExists('posts');
    }
}
