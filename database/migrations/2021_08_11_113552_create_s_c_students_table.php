<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSCStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_c_students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();

            $table->string('phone', 20);
            $table->string('email')->unique();
            $table->string('matric_no')->unique()->nullable();

            $table->string('username', 50)->unique();

            $table->date('dob');
            $table->string('password', 225);
            $table->rememberToken();

            $table->integer('level_id')->nullable()->default('0');

            $table->string('dp', 300)->nullable();
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
        Schema::dropIfExists('s_c_students');
    }
}
