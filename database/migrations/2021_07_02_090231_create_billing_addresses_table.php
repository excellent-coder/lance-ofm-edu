<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', false, true);

            $table->char('phone', 20);
            $table->char('email', 20);

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->integer('country_id', false, true);

            $table->integer('state_id', false, true)->nullable();
            $table->string('state', 100)->nullable();

            $table->integer('city_id', false, true)->nullable();
            $table->string('city', 100)->nullable();

            $table->string('street', 1000);
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
        Schema::dropIfExists('billing_addresses');
    }
}
