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
            $table->bigInteger('subject_id', false, true)->nullable();
            $table->string('topic', 1000)->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('photo')->nullable()->comment('preview photo');

            $table->boolean('active')->nullable()->default(true);
            $table->timestamps();

            $table->foreign('subject_id')->references('id')
                ->on('subjects')->onDelete('SET NULL')->onUpdate('cascade');
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
