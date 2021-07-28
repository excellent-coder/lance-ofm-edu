<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', false, true)->nullable();
            $table->decimal('amount', 10, 2, false);

            // for guest
            $table->string('name', 255)->nullable();
            $table->boolean('anonymous')->nullable()->default(false);
            $table->string('process')->nullable();
            $table->text('remark')->nullable();
            $table->string('status', 100)->nullable()->default('pending');
            // for those that made a deposite, can upload for verification
            $table->string('deposit_proof')->nullable();
            $table->string('ref');
            // this is the payment gateway transaction id
            // peradventure the donor payed through the payment gateway
            // available in the website
            $table->string('transaction_id')->nullable();

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
        Schema::dropIfExists('donations');
    }
}
