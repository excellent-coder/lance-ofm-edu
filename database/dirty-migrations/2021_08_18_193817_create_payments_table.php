<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('guard')
                ->comment('The table hosting the user_id eg. s_c_students, users, members');

            $table->string('currency');
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('ref')->unique();
            $table->string('reason');
            $table->string('mac')->nullable();
            $table->text('device')->nullable();
            $table->ipAddress('ip')->nullable();

            $table->string('transaction_id')
                ->nullable()
                ->comment('commiing from flutterwave');
            $table->string('status')
                ->comment('comming from flutterwave')
                ->nullable()->default('pending');

            $table->dateTime('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
