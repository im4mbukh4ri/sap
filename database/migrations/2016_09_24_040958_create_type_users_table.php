<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_users', function (Blueprint $table) {
            $table->boolean('id')->unsigned();
            $table->string('name',10)->comment('Name of type as Silver, Gold, Platinum');
            /*$table->tinyInteger('center_commission')->default(0);
            $table->tinyInteger('member_commission')->default(0);
            $table->tinyInteger('bonus_commission')->default(0);*/
            $table->timestamps();
            $table->primary('id');
        });
        Schema::create('type_commissions',function (Blueprint $table){
            $table->unsignedTinyInteger('id');
            $table->string('name');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('user_commission',function (Blueprint $table){
            $table->unsignedTinyInteger('id');
            $table->boolean('type_user_id')->unsigned()->comment('FK to type_users');
            $table->unsignedTinyInteger('type_commission_id')->comment('FK to type_commissions table');
            $table->double('commission')->comment('percent commission');
            $table->timestamps();
            $table->foreign('type_user_id')->references('id')->on('type_users')
                ->onUpdate('cascade');
            $table->foreign('type_commission_id')->references('id')->on('type_commissions')
                ->onUpdate('cascade');
        });

        Schema::table('users',function(Blueprint $table){
            $table->boolean('type_user_id')->unsigned()->comment('Member type, FK to type_users table');
            $table->foreign('type_user_id')->references('id')->on('type_users')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function (Blueprint $table){
            $table->dropForeign('users_type_user_id_foreign');
        });
        Schema::dropIfExists('user_commission');
        Schema::dropIfExists('type_commissions');
        Schema::dropIfExists('type_users');
    }
}
