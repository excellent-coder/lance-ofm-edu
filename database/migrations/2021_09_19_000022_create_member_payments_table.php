<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('member_payments');
        Schema::create('member_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->nullable()->unsigned();
            $table->bigInteger('member_request_id')->nullable()->unsigned();

            $table->string('currency');
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('ref')->unique();
            $table->string('reason');

            $table->string('mac')->nullable();
            $table->text('device')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('tag', 100)->nullable();


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
        Schema::dropIfExists('member_payments');
    }
}
