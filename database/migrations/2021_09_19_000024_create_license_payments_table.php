<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('license_payments');
        Schema::create('license_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->bigInteger('payment_id')->unsigned();

            $table->bigInteger('licence_id')->unsigned()->nullable();
            $table->boolean('upgrade')->nullable()->default(false)
                ->comment('true if the payment is for an upgrade and not the initial paymwnt');

            // The duration might chnage from the licence table
            // but once a memberf has been paid before the change
            // his duration will not be affected until next payment
            $table->tinyInteger('duration')
                ->comment('number of years from the day of payment before next payment');

            $table->timestamps();

            // $table->foreign('member_id')->references('id')->on('members')->cascadeOnUpdate();
            // $table->foreign('payment_id')->references('id')->on('member_payments')->cascadeOnUpdate();
            // $table->foreign('licence_id')->references('id')->on('licences')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('license_payments');
    }
}
