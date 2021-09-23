<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->bigInteger('parent_id', false, true)->nullable();
            $table->bigInteger('super_parent', false, true)->nullable();
            // disabling this category any user under that category will
            //  not be able to login and the slug will as well return 404
            $table->boolean('active')->nullable()->default(1);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')
                ->on('user_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('super_parent')->references('id')
                ->on('user_categories')
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
        Schema::dropIfExists('user_categories');
    }
}
