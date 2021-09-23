<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_request_id')->unsigned()->nullable();

            $table->string('name', 400);
            $table->string('email');
            $table->string('phone');
            $table->bigInteger('level_id')->default(1)->comment('The student current level which can change as student level changes');

            // The session the student is admitted
            $table->bigInteger('session_id')->comment('The session the user is admitted');

            // The current active program he is studying
            $table->bigInteger('program_id')->unsigned()->nullable()->comment('Student current program');

            // Student unique matric number
            $table->string('matric_no')->nullable()->unique();
            $table->boolean('active')->nullable()->default(true)->comment('Whether the student is active');
            $table->string('passport')->nullable();

            $table->string('password')->nullable();

            $table->rememberToken();
            $table->timestamps();

            // $table->foreign('program_id')
            //     ->references('id')->on('programs')
            //     ->cascadeOnUpdate()
            //     ->nullOnDelete();

            // $table->foreign('session_id')
            //     ->references('id')->on('sessions')
            //     ->cascadeOnUpdate()
            //     ->nullOnDelete();

            // $table->foreign('student_request_id')->references('id')
            //     ->on('student_requests')
            //     ->nullOnDelete()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
