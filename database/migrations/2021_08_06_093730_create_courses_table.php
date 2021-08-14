<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('slug');

            $table->integer('program_id')->nullable()->unsigned();
            $table->integer('level_id')->nullable()->unsigned();

            $table->string('image', 300)->nullable();
            $table->mediumText('description')->nullable();
            $table->text('excerpt')->nullable();
            $table->boolean('active')->nullable()->default(true);
            $table->timestamps();


            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('level_id')
                ->references('id')
                ->on('levels')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
