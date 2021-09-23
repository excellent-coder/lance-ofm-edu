<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('abbr')->unique();
            $table->string('slug')->unique();
            $table->string('image', 300)->nullable();
            $table->longText('description')->nullable();
            // $table->integer('max_level')->nullable();
            $table->longText('excerpt');
            $table->boolean('active')->nullable()->default(true);
            $table->boolean('is_program')->nullable()->default(true)->comment("if it is a program, students can apply for it");
            $table->tinyInteger('visibility')->nullable()
                ->unsigned()->comment("1 for all, 2 for program alone, and 3 for short course students alone");
            // new
            $table->decimal('main_student_app_fee')->unsigned()->nullable();
            $table->decimal('scs_app_fee')->unsigned()->nullable()
                ->comment('short student application fee');
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
        Schema::dropIfExists('programs');
    }
}
