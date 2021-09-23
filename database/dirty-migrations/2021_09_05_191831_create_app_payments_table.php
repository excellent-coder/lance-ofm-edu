<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('application_id')->unsigned()->nullable();

            $table->string('currency');
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('ref')->unique();
            $table->string('reason', 1000);
            $table->string('mac')->nullable();
            $table->text('device')->nullable();
            $table->ipAddress('ip')->nullable();
            // a common tag that can be used to group
            // payments processed on this table
            $table->string('tag', 100);


            $table->string('transaction_id')
                ->nullable()
                ->comment('from flutterwave');
            $table->string('status')
                ->comment('from flutterwave')
                ->nullable()->default('pending');

            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            // $table->foreign('application_id')->references('id')->on('applications')
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
        Schema::dropIfExists('app_payments');
    }
}
