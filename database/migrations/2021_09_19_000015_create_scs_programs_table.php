<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScsProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scs_programs', function (Blueprint $table) {
            $table->id();
            // This student
            $table->bigInteger('scs_id')->unsigned()->nullable();
            // made payment
            $table->bigInteger('payment_id')->unsigned()->nullable();
            // for this program
            $table->bigInteger('program_id')->unsigned()->nullable();
            $table->timestamps();

            // $table->foreign('scs_id')->references('id')->on('scs')
            //     ->cascadeOnDelete()->cascadeOnUpdate();

            // $table->foreign('program_id')->references('id')->on('programs')
            //     ->cascadeOnDelete()->cascadeOnUpdate();

            // $table->foreign('payment_id')->references('id')->on('scs_payments')
            //     ->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scs_programs');
    }
}
