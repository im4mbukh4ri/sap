<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSipServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('user_commission');

        Schema::create('sip_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->comment('name service of sip : airlines, ppob, hotel, etc.');
            $table->integer('parent_id');
            $table->boolean('status')->comment('1 : open, 0 : close.');
            $table->timestamps();
        });

        // Add foreign key from

        Schema::create('user_commissions', function (Blueprint $table) {
            $table->boolean('type_user_id')->unsigned();
            $table->unsignedTinyInteger('type_commission_id');
            $table->unsignedInteger('sip_service_id');
            $table->double('comission',3,1);
            $table->timestamps();

            $table->foreign('type_user_id')->references('id')->on('type_users')
                ->onUpdate('cascade');
            $table->foreign('type_commission_id')->references('id')->on('type_commissions')
                ->onUpdate('cascade');
            $table->foreign('sip_service_id')->references('id')->on('sip_services')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_commissions');
        Schema::drop('sip_services');
    }
}
