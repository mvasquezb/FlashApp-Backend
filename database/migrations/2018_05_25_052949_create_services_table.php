<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('scheduled_service_id')->unsigned();
            $table->foreign('scheduled_service_id')->references('id')->on('scheduled_services')->onDelete('cascade');
            $table->dateTime('executionDate');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('service_status');
            $table->string('statusComment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
