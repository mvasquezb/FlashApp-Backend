<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('scheduled_service_id')->unsigned();
            $table->foreign('scheduled_service_id')->references('id')->on('scheduled_services')->onDelete('cascade');
            $table->date('requestedDate');
            $table->time('requestedTime');
            $table->string('comment', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_requests');
    }
}
