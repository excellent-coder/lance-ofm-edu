<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAnnualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_annuals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('membership_id')->unsigned();
            $table->bigInteger('payment_id')->unsigned();
            // The date the payment start leading
            $table->date('start_at');
            $table->date('end_at')->comment('The date it will end');
            $table->timestamps();

            // $table->foreign('payment_id')->references('id')->on('member_payments')->onUpdate('cascade');
            // $table->foreign('membership_id')->references('id')->on('memberships')->onUpdate('cascade');
            // $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_annuals');
    }
}
