<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licences', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('slug')->unique();

            $table->decimal('fee', 10)->unsigned()->comment('initial proce');
            $table->decimal('renewal', 10)->unsigned()->comment('renewal proce');
            $table->tinyInteger('duration');
            $table->boolean('active')->nullable()->default(true);
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->string('image', 300)->nullable();
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
        Schema::dropIfExists('licences');
    }
}
