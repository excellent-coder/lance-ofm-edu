<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lesson_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('url')->nullable()->comment('material url to preview');
            $table->string('type', 225)->nullable()->comment('file type of the materia');
            $table->boolean('allow_download')->nullable()->default(true);
            $table->boolean('active')->nullable()->default(true);
            $table->timestamps();

            $table->foreign('lesson_id')->references('id')
                ->on('lessons')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
