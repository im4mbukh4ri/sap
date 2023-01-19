<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCharitiesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('charities', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('content');
			$table->string('url_image')->nullable();
			$table->boolean('status')->default(1)->comment('1 = open, 0 = close');
			$table->timestamps();
		});
		Schema::create('charity_transactions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('charity_id')->unsigned();
			$table->double('nominal', 12, 2);
			$table->string('status')->default('PROCESS')->comment('PROCESS,FAILED,SUCCESS');
			$table->timestamps();
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('charity_id')->references('id')->on('charities');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('charity_transactions');
		Schema::drop('charities');
	}
}
