<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduledServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_services', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('users');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('service_types');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('description', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_services');
    }
}
