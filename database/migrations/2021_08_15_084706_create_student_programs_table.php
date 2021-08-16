<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_programs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->integer('program_id')->unsigned();

            $table->bigInteger('session_id')->unsigned()->nullable();
            $table->integer('level_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('program_id')->references('id')->on('programs')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('session_id')->references('id')->on('sessions')
                ->cascadeOnUpdate()->nullOnDelete();

            $table->foreign('level_id')->references('id')->on('levels')
                ->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_programs');
    }
}
