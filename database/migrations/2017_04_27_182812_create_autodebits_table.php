<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutodebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('number_saveds',function(Blueprint $table){
          $table->integer('id')->unsigned()->change();
        });
        Schema::create('autodebits', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('number_save_id')->unsigned();
            $table->boolean('date');
            $table->boolean('status')->default(1);
            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('number_save_id')->references('id')->on('number_saveds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autodebits');
    }
}
