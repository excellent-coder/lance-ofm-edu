<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserCategorySubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_category_subject', function (Blueprint $table) {
            $table->bigInteger('user_category_id', false, true);
            $table->bigInteger('subject_id', false, true);

            $table->foreign('user_category_id')->references('id')
                ->on('user_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('subject_id')->references('id')
                ->on('subjects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_category_subject');
    }
}
