<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_passengers', function (Blueprint $table) {
            $table->char('id',3)->primary();
            $table->string('type',10)->comment('Type of passenger as Adult, Child, Infant');
        });
        Schema::create('passengers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airlines_transaction_id')->unsigned()->comment('FK to airlines_transactions table');
            $table->char('type',3)->comment('Type of passenger, FK to type_passengers');
            $table->string('title',4)->comment('Passenger title, ex: Mrs, Mr, Ms, Mstr, Miss');
            $table->string('first_name',50)->comment('First name of passenger');
            $table->string('last_name',50)->nullable()->comment('Last name of passenger');
            $table->date('birth_date');
            $table->string('national',50)->comment('National of passanger');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('airlines_transaction_id')->references('id')->on('airlines_transactions')
                ->onUpdate('cascade');
            $table->foreign('type')->references('id')->on('type_passengers')
                ->onUpdate('cascade');
        });
        Schema::create('document_passengers',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('passenger_id')->comment('FK to passengers table');
            $table->string('type')->nullable()->comment('Type of document');
            $table->string('number')->nullable()->comment('Number Identity of document');
            $table->date('expired')->nullable()->comment('Expired of document');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('passenger_id')->references('id')->on('passengers')
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
        Schema::dropIfExists('document_passengers');
        Schema::dropIfExists('passengers');
        Schema::dropIfExists('type_passengers');
    }
}
