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

            $table->string('name', 400);
            $table->string('email')->unique();
            $table->string('phone', 20);

            $table->date('dob');
            $table->string('password', 225);
            $table->rememberToken();

            $table->string('passport', 300)->nullable();
            $table->boolean('active')->default(true)->nullable();

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
