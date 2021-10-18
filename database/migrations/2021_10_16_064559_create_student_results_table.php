<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('program_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('session_id')->unsigned();
            $table->bigInteger('level_id')->unsigned();
            $table->decimal('score');
            $table->date('exam_date')->nullable();
            $table->boolean('retaken')->nullable()->default(false);
            $table->string('remark', 1000)->nullable();
            $table->timestamps();

            // $table->foreign('program_id')->references('id')->on('programs')->cascadeOnUpdate();
            // $table->foreign('course_id')->references('id')->on('courses')->cascadeOnUpdate();
            // $table->foreign('student_id')->references('id')->on('students')->cascadeOnUpdate();
            // $table->foreign('session_id')->references('id')->on('sesions')->cascadeOnUpdate();
            // $table->foreign('level_id')->references('id')->on('levels')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_results');
    }
}
