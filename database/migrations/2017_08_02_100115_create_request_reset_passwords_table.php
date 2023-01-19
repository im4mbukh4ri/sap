<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestResetPasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_reset_passwords', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->string('new_password');
            $table->double('admin');
            $table->boolean('activation')->default(0);
            $table->boolean('confirmed')->default(0);
            $table->boolean('status')->default(0)->comment('0 = waiting, 1 = success, 2 = expired, 3 = canceled');
            $table->dateTime('expired');
            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('request_reset_passwords');
    }
}
