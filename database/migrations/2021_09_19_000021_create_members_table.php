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
            $table->bigInteger('membership_id')->unsigned()->nullable();

            $table->string('member_id')->unique()
                ->nullable()->comment("this is like a matric number");

            $table->bigInteger('member_request_id')->unsigned()
                ->comment('The application form they submitted before approval');

            $table->string('name', 400);
            $table->string('email');
            $table->string('phone');

            $table->boolean('active')->nullable()->default(false);
            $table->string('passport', 300)->nullable();

            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // $table->foreign('membership_id')
            //     ->references('id')->on('memberships')
            //     ->cascadeOnUpdate()
            //     ->nullOnDelete();

            // $table->foreign('member_request_id')
            //     ->references('id')->on('member_requests')
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
        Schema::dropIfExists('members');
    }
}
