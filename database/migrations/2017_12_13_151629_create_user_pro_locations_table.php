<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserProLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->boolean('type_user_id')->unsigned();
            $table->boolean('show_on_map')->default(1);
            $table->boolean('share_location')->default(1);
            $table->string('device');
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->index(['lat', 'lng']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_user_id')->references('id')->on('type_users')
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
        Schema::drop('user_locations');
    }
}
