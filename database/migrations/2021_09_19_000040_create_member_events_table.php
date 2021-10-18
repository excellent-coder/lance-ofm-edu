<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_events', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('payment_id')->nullable();
            $table->timestamps();

            // $table->foreign('event_id')->references('id')->on('events')->cascadeOnUpdate();
            // $table->foreign('member_id')->references('id')->on('members')->cascadeOnUpdate();
            // $table->foreign('payment_id')->references('id')->on('member_payments')->cascadeOnUpdate();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_events');
    }
}
