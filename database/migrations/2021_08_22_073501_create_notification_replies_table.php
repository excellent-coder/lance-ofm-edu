<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_replies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('notification_id')->unsigned()->nullable();
            $table->bigInteger('sender_id');

            $table->bigInteger('user_table_id')->unsigned()->nullable()
                ->comment('for getting the user and the model');

            $table->dateTime('approved_at')->nullable();

            $table->longText('body');
            $table->timestamps();

            $table->foreign('notification_id')->references('id')->on('notifications')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('user_table_id')->references('id')->on('user_tables')
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
        Schema::dropIfExists('notification_replies');
    }
}
