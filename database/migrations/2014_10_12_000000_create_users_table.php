<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('firstSurname', 50);
            $table->string('secondSurname', 50);
            $table->integer('age')->unsigned();
            $table->string('address', 200);
            $table->string('sellerDescription', 500)->nullable();
            $table->string('pictureUrl', 200);
            $table->float('sellerRating')->nullable();
            $table->float('customerRating')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
