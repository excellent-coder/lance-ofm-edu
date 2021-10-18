<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberPubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_pubs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('publication_id')->unsigned();
            $table->bigInteger('payment_id')->unsigned();
            $table->timestamps();

            // $table->foreign('member_id')->references('id')->on('members')->cascadeOnUpdate();
            // $table->foreign('payment_id')->references('id')->on('member_payments')->cascadeOnUpdate();
            // $table->foreign('publication_id')->references('id')->on('publications')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_pubs');
    }
}
