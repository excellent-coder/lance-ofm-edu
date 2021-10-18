<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->bigInteger('session_id')->unsigned()->nullable();
            $table->bigInteger('level_id')->unsigned()->nullable();
            $table->bigInteger('program_id')->unsigned()->nullable();

            $table->bigInteger('student_request_id')->unsigned()->nullable();

            $table->string('currency');
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('ref')->unique();
            $table->text('reason');
            $table->string('mac')->nullable();
            $table->text('device')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('tag')->nullable()->comment('Used to orderly organize the payments based on reason of payment');
            $table->string('item', 100)->comment('The item he is paying for');
            $table->bigInteger('item_id')->unsigned()->nullable()
                ->comment('The id of the item if it exist');

            $table->string('transaction_id')
                ->nullable()
                ->comment('from flutterwave');
            $table->string('status')
                ->comment('from flutterwave')
                ->nullable()->default('pending');

            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            // $table->foreign('student_id')->references('id')->on('students')
            //     ->nullOnDelete()->cascadeOnUpdate();

            // $table->foreign('student_request_id')->references('id')->on('student_requests')
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
        Schema::dropIfExists('student_payments');
    }
}
