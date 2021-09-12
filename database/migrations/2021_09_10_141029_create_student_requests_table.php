<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('program_id')->unsigned()->nullable();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();

            $table->string('phone', 30);
            $table->string('email');
            $table->date('dob');
            $table->string('passport', 225)->nullable();

            $table->text('certificates')->nullable();
            $table->text('documents')->nullable();
            $table->dateTime('email_verified_at')->nullable();

            $table->boolean('reviewed')->nullable()->default(false);
            $table->dateTime('approved_at')->nullable();

            $table->dateTime('rejected_at')->nullable();
            $table->text('reject_reason')->nullable();

            $table->timestamps();


            // $table->foreign('program_id')->references('id')->on('programs')
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
        Schema::dropIfExists('student_requests');
    }
}
