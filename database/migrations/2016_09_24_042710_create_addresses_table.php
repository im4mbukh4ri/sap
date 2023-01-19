<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->char('id',2)->primary();
            $table->string('name',35)->comment('Province name');
            $table->timestamps();
        });
        Schema::create('cities',function (Blueprint $table){
            $table->char('id',4)->primary();
            $table->char('province_id',2)->comment('id province, FK to provinces table');
            $table->string('name')->comment('City name');

            $table->foreign('province_id')->references('id')->on('provinces');
            $table->timestamps();
        });
        Schema::create('subdistricts',function (Blueprint $table){
            $table->char('id',6)->primary();
            $table->char('province_id',2)->comment('id city, FK to provinces table');
            $table->char('city_id',4)->comment('id city, FK to cities table');
            $table->string('name')->comment('Subdistrict name (Kecamatan)');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->timestamps();
        });
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('detail')->comment('Detail address, street name, number, etc.');
            $table->char('subdistrict_id',6)->comment('FK to subdtricts table');
            $table->string('phone');
            $table->foreign('subdistrict_id')->references('id')->on('subdistricts');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users',function (Blueprint $table){
            $table->unsignedInteger('address_id')->comment('FK to addresses table');
            $table->foreign('address_id')->references('id')->on('addresses')
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
        Schema::table('users',function (Blueprint $table){
            $table->dropForeign('users_address_id_foreign');
        });
        Schema::table('cities',function (Blueprint $table){
            $table->dropForeign('cities_province_id_foreign');
        });
        Schema::table('addresses',function (Blueprint $table){
            $table->dropForeign('addresses_subdistrict_id_foreign');
        });
        Schema::dropIfExists('subdistricts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('addresses');
    }
}
