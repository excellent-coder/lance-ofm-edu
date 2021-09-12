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
            $table->Integer('level_id')->default(1);
            $table->bigInteger('session_id')
                ->comment('The session the user is admitted');
            $table->bigInteger('program_id')->unsigned();
            $table->string('matric_no')->nullable();
            $table->boolean('active')->nullable()->default(true);
            $table->string('passport')->nullable();
            // The current active program he is studying

            $table->string('password')->nullable();

            // $table->foreign('program_id')
            //     ->references('id')->on('programs')
            //     ->cascadeOnUpdate()
            //     ->nullOnDelete();
            // $table->foreign('student_request_id')->references('id')
            //     ->on('student_requests')
            //     ->nullOnDelete()->cascadeOnDelete();

            $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
}
