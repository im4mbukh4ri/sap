<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestTransaferDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_transafer_deposits', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->timestamps();
            $table->integer('from_user')->unsigned();
            $table->integer('to_user')->unsigned();
            $table->double('nominal',12,2)->default(0);
            $table->double('admin',8,2)->default(0);
            $table->double('penalty',8,2)->default(0);
            $table->dateTime('expired');
            $table->double('confirmed')->default(0);
            $table->boolean('status')->default(0)->comment('0 = waiting, 1 = success, 2 = expired, 3 = canceled');
            $table->text('note')->nullable();
            $table->string('device',10);
            $table->ipAddress('ip');
            $table->primary('id');
            $table->foreign('from_user')->references('id')->on('users');
            $table->foreign('to_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('request_transafer_deposits');
    }
}
