<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
        Schema::create('scs_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('scs_id')->unsigned()->nullable();

            $table->string('currency');
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('ref')->unique();
            $table->string('reason', 1000);
            $table->string('mac')->nullable();
            $table->text('device')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->bigInteger('scs_program_id')->unsigned()->nullable();
            $table->string('tag')->nullable()->comment('other payments not program');

            $table->string('transaction_id')
                ->nullable()
                ->comment('from flutterwave');

            $table->string('status')
                ->comment('from flutterwave')
                ->nullable()->default('pending');

            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            // $table->foreign('scs_id')->references('id')->on('scs')
            //     ->nullOnDelete()->cascadeOnUpdate();

            // $table->foreign('scs_program_id')->references('id')->on('programs')
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
        Schema::dropIfExists('scs_payments');
    }
}
