<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventGoersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_goers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->bigInteger('goer_id')->nullable();
            $table->string('goer')->nullable();

            $table->string('email');
            $table->string('phone')->nullable();
            $table->bigInteger('payment_id')->nullable();
            $table->boolean('paid')->nullable()->default(false);
            $table->string('password');
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')
                ->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_goers');
    }
}
