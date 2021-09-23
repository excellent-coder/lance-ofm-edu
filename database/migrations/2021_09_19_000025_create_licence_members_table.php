<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicenceMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licence_members', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->nullable()->unsigned();
            $table->bigInteger('licence_id')->nullable()->unsigned();
            $table->bigInteger('payment_id')->nullable();

            $table->timestamps();

            // $table->foreign('licence_id')->references('id')->on('licences')
            //     ->nullOnDelete()->cascadeOnUpdate();

            // $table->foreign('payment_id')->references('id')->on('license_payments')
            //     ->nullOnDelete()->cascadeOnUpdate();

            // $table->foreign('member_id')->references('id')->on('members')
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
        Schema::dropIfExists('licence_members');
    }
}
