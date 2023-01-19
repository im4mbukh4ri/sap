<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name',50)->comment('Name of bank');
            $table->string('number',50)->comment('Account number');
            $table->string('owner_name')->comment('Name of bank account');
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
        Schema::drop('sip_banks');
    }
}
