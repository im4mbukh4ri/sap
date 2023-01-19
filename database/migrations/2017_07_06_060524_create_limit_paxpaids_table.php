<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLimitPaxpaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limit_paxpaids', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type_user_id')->unsigned();
            $table->integer('sip_service_id')->unsigned();
            $table->double('limit',14,2);
            $table->timestamps();
            $table->foreign('type_user_id')->references('id')->on('type_users');
            $table->foreign('sip_service_id')->references('id')->on('sip_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('limit_paxpaids');
    }
}
