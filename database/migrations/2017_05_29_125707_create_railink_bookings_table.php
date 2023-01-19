<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRailinkBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('railink_bookings', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->integer('train_transaction_id')->unsigned();
          $table->char('depart_return_id',1)->default('d');
          $table->char('origin',3);
          $table->char('destination',3);
          $table->string('train_name',50);
          $table->string('train_number',20);
          $table->string('class',20);
          $table->string('subclass',5);
          $table->timestamp('etd')->nullable();
          $table->timestamp('eta')->nullable();
          $table->double('paxpaid',12,2)->default(0);
          $table->double('nta',12,2)->default(0);
          $table->double('nra',12,2)->default(0);
          $table->double('pr',8,2)->default(0);
          $table->string('status',20)->default('process');
          $table->string('pnr',10)->nullable();
          $table->foreign('train_transaction_id')->references('id')->on('train_transactions');
          $table->foreign('depart_return_id')->references('id')->on('depart_return');
          $table->foreign('origin')->references('code')->on('railink_stations');
          $table->foreign('destination')->references('code')->on('railink_stations');
        });
        Schema::create('railink_commissions',function(Blueprint $table){
          $table->increments('id');
          $table->timestamps();
          $table->integer('railink_booking_id')->unsigned();
          $table->double('nra',12,2)->default(0);
          $table->double('komisi',12,2)->default(0);
          $table->double('free',12,2)->default(0);
          $table->double('pusat',12,2)->default(0);
          $table->double('bv',12,2)->default(0);
          $table->double('member',12,2)->default(0);
          $table->double('upline',12,2)->default(0);
          $table->foreign('railink_booking_id')->references('id')->on('railink_bookings');
        });
        Schema::create('railink_booking_transaction_numbers',function(Blueprint $table){
          $table->increments('id');
          $table->integer('railink_booking_id')->unsigned();
          $table->string('transaction_number')->nullable();
          $table->foreign('railink_booking_id')->references('id')->on('railink_bookings');
        });
        Schema::create('railink_booking_failed_messages',function(Blueprint $table){
          $table->increments('id');
          $table->integer('railink_booking_id')->unsigned();
          $table->text('message');
          $table->foreign('railink_booking_id')->references('id')->on('railink_bookings');
        });
        Schema::create('railink_passanger_seats',function(Blueprint $table){
          $table->integer('train_passanger_id')->unsigned();
          $table->integer('railink_booking_id')->unsigned();
          $table->integer('train_seat_id')->unsigned();
          $table->foreign('train_passanger_id')->references('id')->on('train_passengers');
          $table->foreign('railink_booking_id')->references('id')->on('railink_bookings');
          $table->foreign('train_seat_id')->references('id')->on('train_seats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('railink_bookings');
    }
}
