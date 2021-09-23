<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_requests', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('membership_id')->unsigned()->nullable();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();

            $table->string('phone');
            $table->string('email');
            $table->date('dob');

            $table->string('passport', 300)->nullable();

            $table->text('certificates')->nullable();
            $table->text('documents')->nullable();
            $table->dateTime('email_verified_at')->nullable();

            $table->boolean('reviewed')->nullable()->default(false);
            $table->dateTime('approved_at')->nullable();

            $table->dateTime('rejected_at')->nullable();
            $table->text('reject_reason')->nullable();

            $table->timestamps();

            // $table->foreign('membership_id')
            //     ->references('id')->on('memberships')
            //     ->cascadeOnUpdate()
            //     ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_requests');
    }
}
