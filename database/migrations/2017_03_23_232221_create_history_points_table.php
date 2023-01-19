<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->smallInteger('point')->default(0);
            $table->smallInteger('debit')->default(0);
            $table->smallInteger('credit')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::create('point_rewards',function (Blueprint $table){
            $table->boolean('id')->unsigned();
            $table->tinyInteger('point');
            $table->timestamps();
            $table->primary('id');
        });
        Schema::create('point_values',function (Blueprint $table){
            $table->boolean('id')->unsigned();
            $table->double('idr');
            $table->timestamps();
            $table->primary('id');
        });
        Schema::create('point_max',function (Blueprint $table){
            $table->boolean('id')->unsigned();
            $table->tinyInteger('point');
            $table->timestamps();
            $table->primary('id');
        });
        Schema::create('points',function (Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->smallInteger('user_point')->default(0);
            $table->smallInteger('debit')->default(0);
            $table->smallInteger('credit')->default(0);
            $table->text('note')->nullable();
            $table->integer('created_by')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('points');
        Schema::drop('point_max');
        Schema::drop('point_values');
        Schema::drop('point_rewards');
        Schema::drop('history_points');
    }
}
