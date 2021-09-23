<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScsCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scs_courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('scs_id')->nullable()->unsigned();
            //The program they are studying these courses under
            $table->bigInteger('scs_program_id')->nullable()->unsigned();
            $table->bigInteger('course_id')->nullable()->unsigned();
            $table->bigInteger('session_id')->unsigned()->nullable();
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
        Schema::dropIfExists('scs_courses');
    }
}
