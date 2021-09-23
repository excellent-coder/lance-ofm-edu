<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('slug')->unique();

            $table->decimal('application_fee')->nullable();
            $table->decimal('annual_fee')->nullable();
            $table->decimal('admin_fee')->nullable()->comment('administrative fee');

            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->boolean('active')->default(true)
                ->comment('1 means that it is accepting applications');
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
        Schema::dropIfExists('memberships');
    }
}
