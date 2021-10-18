<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('session_id')->unsigned()->nullable();
            $table->bigInteger('program_id')->unsigned()->nullable();
            $table->bigInteger('level_id')->unsigned()->nullable();
            $table->string('fee');
            $table->decimal('amount')->unsigned();
            $table->string('currency')->default('NGN');
            $table->string('reason', 1500);
            $table->timestamps();

            // $table->foreign('session_id')->references('id')->on('sessions')->cascadeOnUpdate();
            // $table->foreign('program_id')->references('id')->on('programs')->cascadeOnUpdate();
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
        Schema::dropIfExists('student_fees');
    }
}
