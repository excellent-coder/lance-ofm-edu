<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('abbr')->unique();
            $table->string('slug');
            $table->string('image', 300)->nullable();
            $table->mediumText('description')->nullable();
            $table->integer('max_level');
            $table->text('excerpt');
            $table->boolean('active')->nullable()->default(true);
            $table->boolean('is_program')->nullable()->default(true);
            $table->tinyInteger('visibility')->unsigned()->comment("1 for all, 2 for program alone, and 3 for short course students alone");
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
        Schema::dropIfExists('programs');
    }
}
