<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_results', function (Blueprint $table) {
            // $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('questionnaire_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('question_form_id')->unsigned();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('question_form_id')->references('id')->on('question_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questionnaire_results');
    }
}
