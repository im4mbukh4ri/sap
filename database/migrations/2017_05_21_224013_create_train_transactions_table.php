<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_transactions', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('buyer_id')->unsigned();
            $table->integer('sip_service_id')->unsigned();
            $table->char('trip_type_id',1);
            $table->boolean('adt')->default(1);
            $table->boolean('chd')->default(0);
            $table->boolean('inf')->default(0);
            $table->double('total_fare',12,2)->default(0);
            $table->string('device',10);
            $table->softDeletes();
            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('buyer_id')->references('id')->on('buyers');
            $table->foreign('sip_service_id')->references('id')->on('sip_services');
            $table->foreign('trip_type_id')->references('id')->on('trip_types');
        });

        Schema::create('train_bookings',function (Blueprint $table){
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
          $table->double('paxpaid',12,2)->default(0);
          $table->double('nta',12,2)->default(0);
          $table->double('nra',12,2)->default(0);
          $table->double('pr',8,2)->default(0);
          $table->string('status',20)->default('process');
          $table->string('pnr',10)->nullable();
          $table->foreign('train_transaction_id')->references('id')->on('train_transactions');
          $table->foreign('depart_return_id')->references('id')->on('depart_return');
          $table->foreign('origin')->references('code')->on('stations');
          $table->foreign('destination')->references('code')->on('stations');
        });
        Schema::create('train_commissions',function(Blueprint $table){
          $table->increments('id');
          $table->timestamps();
          $table->integer('train_booking_id')->unsigned();
          $table->double('nra',12,2)->default(0);
          $table->double('komisi',12,2)->default(0);
          $table->double('free',12,2)->default(0);
          $table->double('pusat',12,2)->default(0);
          $table->double('bv',12,2)->default(0);
          $table->double('member',12,2)->default(0);
          $table->double('upline',12,2)->default(0);
          $table->foreign('train_booking_id')->references('id')->on('train_bookings');
        });
        Schema::create('train_passengers',function(Blueprint $table){
          $table->increments('id');
          $table->timestamps();
          $table->integer('train_transaction_id')->unsigned();
          $table->string('name');
          $table->char('type',3);
          $table->string('identity_number')->nullable();
          $table->string('phone',25)->nullable();
          $table->foreign('train_transaction_id')->references('id')->on('train_transactions');
          $table->foreign('type')->references('id')->on('type_passengers');
        });
        Schema::create('train_booking_transaction_numbers',function(Blueprint $table){
          $table->increments('id');
          $table->integer('train_booking_id')->unsigned();
          $table->string('transaction_number')->nullable();
          $table->foreign('train_booking_id')->references('id')->on('train_bookings');
        });
        Schema::create('train_booking_failed_messages',function(Blueprint $table){
          $table->increments('id');
          $table->integer('train_booking_id')->unsigned();
          $table->text('message');
          $table->foreign('train_booking_id')->references('id')->on('train_bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('train_booking_failed_messages');
        Schema::drop('train_booking_transaction_numbers');
        Schema::drop('train_passengers');
        Schema::drop('train_commissions');
        Schema::drop('train_bookings');
        Schema::drop('train_transactions');
    }
}
