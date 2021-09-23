<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('settings', function (Blueprint $table) {
            $table->foreign('tag_id')
                ->references('id')
                ->on('setting_tags')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('level_id')
                ->references('id')
                ->on('levels')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });

        Schema::table('student_requests', function (Blueprint $table) {
            $table->foreign('program_id')->references('id')->on('programs')
                ->nullOnDelete()->cascadeOnDelete();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreign('program_id')
                ->references('id')->on('programs')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('session_id')
                ->references('id')->on('sessions')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('student_request_id')->references('id')
                ->on('student_requests')
                ->nullOnDelete()->cascadeOnDelete();
        });

        Schema::table('student_payments', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('student_request_id')->references('id')->on('student_requests')
                ->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::table('student_courses', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->nullOnDelete()->cascadeOnDelete();
            $table->foreign('course_id')->references('id')->on('courses')->nullOnDelete()->cascadeOnDelete();
            $table->foreign('session_id')->references('id')->on('sessions')->nullOnDelete()->cascadeOnDelete();
        });

        Schema::table('member_requests', function (Blueprint $table) {
            $table->foreign('membership_id')
                ->references('id')->on('memberships')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });

        Schema::table('member_appeals', function (Blueprint $table) {
            $table->foreign('member_request_id')->references('id')->on('member_requests')
                ->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::table('members', function (Blueprint $table) {
            $table->foreign('membership_id')
                ->references('id')->on('memberships')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreign('member_request_id')
                ->references('id')->on('member_requests')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });

        Schema::table('member_payments', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('member_request_id')->references('id')->on('member_requests')
                ->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::table('license_payments', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('licence_id')->references('id')->on('licences')
                ->nullOnDelete()->cascadeOnUpdate();
        });

        Schema::table('licence_members', function (Blueprint $table) {
            $table->foreign('licence_id')->references('id')->on('licences')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('payment_id')->references('id')->on('license_payments')
                ->nullOnDelete()->cascadeOnUpdate();

            $table->foreign('member_id')->references('id')->on('members')
                ->nullOnDelete()->cascadeOnUpdate();
        });

        // Schema::table('t', function(Blueprint $table){

        // });

        // Schema::table('t', function(Blueprint $table){

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
