<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('maxOccurrences')->unsigned();
            $table->integer('dayOfWeek')->unsigned();
            $table->integer('weekOfMonth')->unsigned();
            $table->integer('monthOfYear')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('scheduled_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
