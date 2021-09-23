<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('applying_for');
            $table->string('item')->comment("The item he applied for");
            $table->string('item_id')->comment("The id of the item he applied for");

            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();

            $table->string('phone', 30);
            $table->string('email');
            $table->date('dob');
            $table->string('passport', 225)->nullable();


            $table->string('applicant');
            //  ['guest', 'scs', 'pgs', 'mem'])->nullable();
            $table->bigInteger('applicant_id')->unsigned()->nullable();

            $table->string('form')->nullable();
            $table->text('certificates')->nullable();
            $table->text('documents')->nullable();

            $table->boolean('reviewed')->nullable()->default(false);
            $table->dateTime('rejected_at')->nullable();
            $table->text('reject_reason')->nullable();
            $table->dateTime('approved_at')->nullable();

            $table->bigInteger('payment_id')->nullable();

            $table->ipAddress('ip');
            $table->text('device')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
