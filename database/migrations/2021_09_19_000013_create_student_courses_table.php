<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_courses', function (Blueprint $table) {
            $table->id();
            // This student
            $table->bigInteger('student_id')->unsigned()->nullable();
            // Took this course
            $table->bigInteger('course_id')->unsigned()->nullable();
            // In this session
            $table->bigInteger('session_id')->unsigned()->nullable();
            // At this level
            $table->integer('level_id');
            // $table->string()

            // $table->foreign('student_id')->references('id')->on('students')->nullOnDelete()->cascadeOnDelete();
            // $table->foreign('course_id')->references('id')->on('courses')->nullOnDelete()->cascadeOnDelete();
            // $table->foreign('session_id')->references('id')->on('sessions')->nullOnDelete()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_courses');
    }
}
