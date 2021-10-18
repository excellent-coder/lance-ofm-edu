<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentActivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('student_actives');
        Schema::create('student_actives', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('program_id')->unsigned();
            $table->bigInteger('session_id')->unsigned();

            $table->bigInteger('level_id')->unsigned();
            $table->bigInteger('payment_id')->unsigned();
            $table->bigInteger('exam_id')->unsigned()->nullable();
            $table->bigInteger('exam_center_id')->unsigned()->nullable();

            $table->boolean('passed')->nullable()->default(false);
            $table->decimal('average')->unsigned()->nullable();
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
        Schema::dropIfExists('student_actives');
    }
}
