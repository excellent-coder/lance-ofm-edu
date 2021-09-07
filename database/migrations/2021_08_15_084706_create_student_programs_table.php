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
            // The program he is studying
            $table->integer('program_id')->unsigned();

            // The session at which he was approved
            $table->bigInteger('session_id')->unsigned()->nullable();

            // The level he startes from, default 1
            $table->integer('level_id')->unsigned()->nullable();
            $table->boolean('active')->nullable()->default(true);
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
