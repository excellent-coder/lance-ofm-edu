<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('student_active_id')->unsigned();

            // $table->bigInteger('program_id')->unsigned()->nullable();
            // $table->bigInteger('session_id')->unsigned()->nullable();
            // $table->bigInteger('level_id')->unsigned()->nullable();

            $table->decimal('average')->unsigned()->nullable();
            $table->boolean('passed')->nullable()->default(false);
            $table->text('comment')->nullable();
            // dynamic columns generated with course code
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
        Schema::dropIfExists('student_exams');
    }
}
