<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('events');
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->decimal('price')->nullable();

            $table->string('image');
            $table->text('description');

            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->bigInteger('event_cat_id')->unsigned()->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->timestamps();

            $table->foreign('event_cat_id')->references('id')->on('event_cats')
                ->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
