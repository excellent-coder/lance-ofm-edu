<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', false, true);

            $table->bigInteger('user_category_id', false, true)->nullable();

            $table->foreign('user_category_id')->references('id')
                ->on('user_categories')
                ->onDelete("SET NULL")
                ->onUpdate('CASCADE');

            $table->boolean('reviewed')->nullable()->default(false);
            $table->dateTime('approved_at')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
