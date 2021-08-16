<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->unique()
                ->nullable()->comment("this is like a matric number");

            $table->string('email');
            $table->string('phone');
            $table->string('password');

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->bigInteger('membership_id')->unsigned()->nullable();

            $table->date('accepted_on')->nullable();
            $table->date('disabled_on')->nullable();
            $table->date('terminated_on')->nullable();

            $table->string('image', 300)->nullable();

            $table->boolean('active')->nullable()->default(false);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('membership_id')
                ->references('id')->on('memberships')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
