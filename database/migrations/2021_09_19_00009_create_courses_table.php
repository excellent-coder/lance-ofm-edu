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
            $table->string('code')->unique();
            $table->string('slug')->unique();

            $table->integer('program_id')->nullable()->unsigned();
            $table->integer('level_id')->nullable()->unsigned();

            $table->string('image', 300)->nullable();
            $table->longText('description')->nullable();
            $table->longText('excerpt')->nullable();
            $table->boolean('active')->nullable()->default(true);
            $table->tinyInteger('visibility')->nullable()
                ->unsigned()->comment("1 for all, 2 for program alone, and 3 for short course students alone");
            // new
            $table->timestamps();


            // $table->foreign('program_id')
            //     ->references('id')
            //     ->on('programs')
            //     ->cascadeOnUpdate()
            //     ->nullOnDelete();

            // $table->foreign('level_id')
            //     ->references('id')
            //     ->on('levels')
            //     ->cascadeOnUpdate()
            //     ->nullOnDelete();
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
