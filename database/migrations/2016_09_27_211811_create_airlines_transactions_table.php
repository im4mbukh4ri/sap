<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlinesTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('airports',function (Blueprint $table){
            $table->char('id',3)->primary();
            $table->string('name')->comment('Airport name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('flight_types',function (Blueprint $table){
            $table->char('id',1)->primary();
            $table->string('name',20)->comment('Name type');

        });
        Schema::create('buyers',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone',15)->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('airlines_transactions', function (Blueprint $table) {
            $table->integer('id')->unsigned()->unique()->comment('ID Airlines Transaction');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('buyer_id');
//            $table->char('origin',3)->comment('Origin airport');
//            $table->char('destination',3)->comment('Destination airport');
            $table->char('flight_type_id',1)->default('o')->comment('o = One Way, r = Return');
            $table->tinyInteger('adt')->default(0)->comment('Count of adult passenger');
            $table->tinyInteger('chd')->default(0)->comment('Count of child passenger');
            $table->tinyInteger('inf')->default(0)->comment('Count of infant passenger');
            $table->double('total_fare',12,2)->default(0)->comment('Total fare');
//            $table->string('status',20)->default('waiting-isued')->comment('Status transaction');
            $table->timestamps();
            $table->dateTime('expired')->comment('Expired time / time limit for issued');
            $table->softDeletes();
            $table->primary('id');
//            $table->foreign('origin')->references('id')->on('airports')
//                ->onUpdate('cascade');
//            $table->foreign('destination')->references('id')->on('airports')
//                ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade');
            $table->foreign('buyer_id')->references('id')->on('buyers')
                ->onUpdate('cascade');
            $table->foreign('flight_type_id')->references('id')->on('flight_types')
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
        Schema::dropIfExists('airlines_transactions');
        Schema::dropIfExists('buyers');
        Schema::dropIfExists('flight_types');
        Schema::dropIfExists('airports');
    }
}
