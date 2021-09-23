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
        Schema::create('license_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned()->nullable();

            $table->string('currency');
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('ref')->unique();
            $table->string('reason', 1000);
            $table->string('mac')->nullable();

            $table->ipAddress('ip')->nullable();
            $table->bigInteger('licence_id')->unsigned()->nullable();
            // a common tag that can be used to group
            // payments processed on this table
            $table->boolean('upgrade')->nullable()->default(false)
                ->comment('true if the payment is for an upgrade and not the initial paymwnt');

            // The duration might chnage from the licence table
            // but once a memberf has been paid before the change
            // his duration will not be affected until next payment
            $table->tinyInteger('duration')
                ->comment('number of years from the day of payment before next payment');

            $table->string('transaction_id')
                ->nullable()
                ->comment('from flutterwave');
            $table->string('status')
                ->comment('from flutterwave')
                ->nullable()->default('pending');

            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            // $table->foreign('member_id')->references('id')->on('members')
            //     ->nullOnDelete()->cascadeOnUpdate();

            // $table->foreign('licence_id')->references('id')->on('licences')
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
        Schema::dropIfExists('license_payments');
    }
}
