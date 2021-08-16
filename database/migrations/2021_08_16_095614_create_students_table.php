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

            $table->string('email');
            $table->string('phone');
            $table->string('password');

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->bigInteger('program_id')->unsigned();

            $table->date('accepted_on')->nullable();
            $table->date('disabled_on')->nullable();
            $table->date('terminated_on')->nullable();

            $table->string('image', 300)->nullable();

            $table->boolean('active')->nullable()->default(true);

            $table->foreign('program_id')
                ->references('id')->on('programs')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->Integer('level_id')->default(1);
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
