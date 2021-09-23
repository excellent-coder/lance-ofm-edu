<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAppealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_appeals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_request_id')->unsigned()->nullable();
            $table->longText('reason');
            $table->timestamps();

            // $table->foreign('member_request_id')->references('id')->on('member_requests')
            //     ->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_appeals');
    }
}
