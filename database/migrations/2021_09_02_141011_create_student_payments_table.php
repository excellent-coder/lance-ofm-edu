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

            $table->string('currency');
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('ref')->unique();
            $table->string('reason');
            $table->string('mac')->nullable();
            $table->text('device')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('tag', 100);


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
