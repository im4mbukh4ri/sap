<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned();
            // $table->tinyInteger('value')->nullable();
            $table->string('text')->nullable();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('question_forms');
    }
}
