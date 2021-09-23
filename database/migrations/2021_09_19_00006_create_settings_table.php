<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tag_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('name');
            $table->text('value');
            $table->timestamps();

            // $table->foreign('tag_id')
            //     ->references('id')
            //     ->on('setting_tags')
            //     ->onDelete('set null')
            //     ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
