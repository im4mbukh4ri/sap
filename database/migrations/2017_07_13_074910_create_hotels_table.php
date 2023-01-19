<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_cities', function (Blueprint $table) {
            $table->string('id',10);
            $table->string('city');
            $table->boolean('international');
            $table->string('country');
            $table->timestamps();
            $table->primary('id');
        });
        Schema::create('hotels',function(Blueprint $table){
          $table->increments('id');
          $table->string('hotel_city_id',10);
          $table->string('name');
          $table->double('rating',3,2)->default(0);
          $table->string('address')->nullable();
          $table->string('email',100)->nullable();
          $table->string('website',100)->nullable();
          $table->string('url_image')->nullable();
          $table->timestamps();
          $table->foreign('hotel_city_id')->references('id')->on('hotel_cities');
        });
        Schema::create('hotel_rooms',function(Blueprint $table){
          $table->increments('id');
          $table->integer('hotel_id')->unsigned();
          $table->string('name',20);
          $table->string('bed',20);
          $table->string('board');
          $table->timestamps();
          $table->foreign('hotel_id')->references('id')->on('hotels');
        });
        Schema::create('hotel_room_fares',function(Blueprint $table){
          $table->integer('hotel_room_id')->unsigned();
          $table->integer('selected_id')->unsigned();
          $table->integer('selected_id_room')->unsigned();
          $table->date('checkin');
          $table->date('checkout');
          $table->decimal('price',12,2)->default(0);
          $table->decimal('nta',12,2)->default(0);
          $table->timestamps();
          $table->primary('selected_id_room');
          $table->foreign('hotel_room_id')->references('id')->on('hotel_rooms');
        });
        Schema::create('hotel_transactions', function(Blueprint $table){
          $table->integer('id')->unsigned();
          $table->timestamps();
          $table->integer('user_id')->unsigned();
          $table->integer('hotel_id')->unsigned();
          $table->date('checkin');
          $table->date('checkout');
          $table->boolean('adt')->default(1);
          $table->boolean('chd')->default(0);
          $table->boolean('inf')->default(0);
          $table->tinyInteger('room')->default(0);
          $table->double('total_fare',12,2)->default(0);
          $table->double('nta',12,2)->default(0);
          $table->double('nra',12,2)->default(0);
          $table->double('pr',8,2)->default(0);
          $table->string('status',20)->default('process');
          $table->string('device',10);
          $table->primary('id');
          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('hotel_id')->references('id')->on('hotels');
        });
        Schema::create('hotel_transaction_room',function(Blueprint $table){
          $table->integer('hotel_transaction_id')->unsigned();
          $table->integer('hotel_room_id')->unsigned();
          $table->foreign('hotel_transaction_id')->references('id')->on('hotel_transactions');
          $table->foreign('hotel_room_id')->references('id')->on('hotel_rooms');
        });
        Schema::create('hotel_commissions',function(Blueprint $table){
          $table->increments('id');
          $table->timestamps();
          $table->integer('hotel_transaction_id')->unsigned();
          $table->double('nra',12,2)->default(0);
          $table->double('komisi',12,2)->default(0);
          $table->double('free',12,2)->default(0);
          $table->double('pusat',12,2)->default(0);
          $table->double('bv',12,2)->default(0);
          $table->double('member',12,2)->default(0);
          $table->double('upline',12,2)->default(0);
          $table->foreign('hotel_transaction_id')->references('id')->on('hotel_transactions');
        });
        Schema::create('hotel_guests',function(Blueprint $table){
          $table->increments('id');
          $table->integer('hotel_transaction_id')->unsigned();
          $table->string('name');
          $table->char('type',3)->default('adt');
          $table->string('phone',25)->nullable();
          $table->foreign('hotel_transaction_id')->references('id')->on('hotel_transactions');
          $table->foreign('type')->references('id')->on('type_passengers');
        });
        Schema::create('hotel_guest_note',function(Blueprint $table){
          $table->increments('id');
          $table->integer('hotel_transaction_id')->unsigned();
          $table->text('note')->nullbale();
          $table->foreign('hotel_transaction_id')->references('id')->on('hotel_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotels');
    }
}
