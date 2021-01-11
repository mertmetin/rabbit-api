<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('label')->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('zone_code');
            $table->string('postal_code')->nullable();
            $table->string('city');
            $table->string('country_code');
            $table->decimal('latitude', 8, 6)->default(0);
            $table->decimal('longitude', 9, 6)->default(0);	
            $table->string('notes')->nullable();
            $table->integer('address_type')->unsigned();
            $table->foreign('address_type')->references('id')->on('address_types');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_addresses');
    }
}
