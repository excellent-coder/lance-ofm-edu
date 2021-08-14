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
            $table->bigInteger('item_id')->unsigned()
                ->comment('The id of the item you are applying for');

            $table->string('applicant');
            //  ['guest', 'scs', 'pgs', 'mem'])->nullable();
            $table->bigInteger('applicant_id')->unsigned()->nullable();

            $table->string('form')->nullable();

            $table->boolean('reviewed')->nullable()->default(false);
            $table->dateTime('approved_at')->nullable();
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
