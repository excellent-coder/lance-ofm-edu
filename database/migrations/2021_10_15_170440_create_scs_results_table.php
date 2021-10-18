<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scs_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('scs_id')->unsigned();
            $table->bigInteger('program_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->decimal('score');
            $table->date('exam_date')->nullable();
            $table->string('remark', 1000)->nullable();
            $table->timestamps();

            // $table->foreign('program_id')->references('id')->on('programs')->cascadeOnUpdate();
            // $table->foreign('course_id')->references('id')->on('courses')->cascadeOnUpdate();
            // $table->foreign('scs_id')->references('id')->on('scs')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scs_results');
    }
}
