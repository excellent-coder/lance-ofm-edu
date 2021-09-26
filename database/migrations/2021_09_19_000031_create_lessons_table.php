<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id', false, true)->nullable();
            $table->bigInteger('session_id', false, true)->nullable();
            $table->string('topic', 1000)->nullable();
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('image', 300)->nullable()->comment('preview image');

            $table->boolean('active')->nullable()->default(true);
            $table->tinyInteger('visibility')->default(1)
                ->comment("Determines those whp can access the course, 1=all, 2=main, 3=scs");
            $table->timestamps();

            // $table->foreign('course_id')->references('id')
            //     ->on('courses')->onDelete('SET NULL')->onUpdate('cascade');
            // $table->foreign('session_id')->references('id')
            //     ->on('sessions')->onDelete('SET NULL')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
